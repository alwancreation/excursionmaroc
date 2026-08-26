<?php
namespace App\Services;

use App\Entity\AppSettings;
use App\Entity\Page;
use App\Entity\Product;
use App\Entity\Vehicle;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SeoService{
    /** @var  Router */
    protected $router;
    protected $em;
    protected $container;

    public function __construct(Router $router,EntityManager $em, Container $container)
    {
        $this->router = $router;
        $this->em = $em;
        $this->container = $container;
    }

    private function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Construit une URL absolue à partir d'un chemin relatif (ex: /uploads/x.jpg),
     * en s'appuyant sur le contexte de routage courant (scheme + host).
     */
    private function absoluteUrl(string $path): string
    {
        $context = $this->router->getContext();
        $host = $context->getHost();
        if (!$host) {
            return $path;
        }

        $scheme = $context->getScheme() ?: 'https';
        $port = '';
        if ('http' === $scheme && 80 !== $context->getHttpPort()) {
            $port = ':' . $context->getHttpPort();
        } elseif ('https' === $scheme && 443 !== $context->getHttpsPort()) {
            $port = ':' . $context->getHttpsPort();
        }

        return $scheme . '://' . $host . $port . $path;
    }

    private function getSettingsObject(): \stdClass
    {
        $settings = $this->em->getRepository(AppSettings::class)->findAll();
        $settingsObject = new \stdClass();
        /** @var AppSettings $setting */
        foreach ($settings as $setting){
            $settingsObject->{$setting->getKey()} = $setting->getValue();
        }

        return $settingsObject;
    }

    public function getMeta(){
        $settingsObject = $this->getSettingsObject();
        $name = $this->e($settingsObject->application_name ?? '');
        $description = $this->e($settingsObject->application_description ?? '');

        return '
        <title>'.$name.'</title>
        <meta name="description" content="'.$description.'">
        <meta property="og:title" content="'.$name.'"/>
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="'.$description.'"/>
        ';

    }

    public function metaProduct(Product $product){
        $settingsObject = $this->getSettingsObject();
        $siteName = $this->e($settingsObject->application_name ?? '');
        $title = $this->e($product->getProductName() . ' - ' . ($settingsObject->application_name ?? ''));
        $description = $this->e(substr((string) $product->getProductShortDescription(), 0, 200));

        $canonical = '';
        $ogImage = '';
        try {
            $url = $this->router->generate('product_details', [
                'id' => $product->getProductId(),
                'slug' => (new Utils())->slugify($product->getProductSlug() ?: (string) $product, ['transliterate' => true]),
                'category' => (new Utils())->slugify((string) $product->getCategory(), ['transliterate' => true]),
            ], UrlGeneratorInterface::ABSOLUTE_URL);
            $canonical = '<link rel="canonical" href="'.$this->e($url).'"/>';
        } catch (\Throwable $e) {
            // routage impossible (ex: pas de contexte de requête) -> pas de canonical, tant pis
        }

        $firstImage = $product->getImages() && $product->getImages()->count() > 0
            ? $product->getImages()->first()
            : null;
        if ($firstImage && $firstImage->getPath()) {
            $ogImageUrl = $this->absoluteUrl('/uploads/excursions/' . $firstImage->getPath());
            $ogImage = '<meta property="og:image" content="'.$this->e($ogImageUrl).'"/>';
        }

        return '
        <title>'.$title.'</title>
        <meta name="description" content="'.$description.'">
        '.$canonical.'
        <meta property="og:title" content="'.$title.'"/>
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="'.$description.'"/>
        <meta property="og:site_name" content="'.$siteName.'"/>
        '.$ogImage.'
        ';

    }

    public function metaPage(?Page $page){
        if (!$page) {
            return $this->getMeta();
        }

        $meta = $page->getMeta();
        if($meta  && $meta->getMetaTitle()){
            return '
            <title>'.$this->e($meta->getMetaTitle()).'</title>
            <meta name="description" content="'.$this->e($meta->getMetaDescription()).'">
            <meta name="keywords" content="'.$this->e($meta->getMetaKeywords()).'">
            <meta property="og:title" content="'.$this->e($meta->getMetaTitle()).'"/>
            <meta property="og:type" content="website"/>
            <meta property="og:description" content="'.$this->e($meta->getMetaDescription()).'"/>
            '.$meta->getMetaPlus();
        }
        $settingsObject = $this->getSettingsObject();
        $title = $this->e($page->getPageTitle() . ' - ' . ($settingsObject->application_name ?? ''));
        $description = $this->e(substr((string) $page->getPageShortDescription(), 0, 200));

        return '
        <title>'.$title.'</title>
        <meta name="description" content="'.$description.'">
        <meta property="og:title" content="'.$title.'"/>
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="'.$description.'"/>
        ';

    }

}
