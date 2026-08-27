<?php

namespace App\Controller\Agency;

use App\Entity\Agency;
use App\Services\AgencyContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractAgencyController extends AbstractController
{
    protected AgencyContext $agencyContext;

    /**
     * Setter injection (rather than a constructor) so that concrete
     * controllers with their own constructor don't have to repeat this.
     *
     * @required
     */
    public function setAgencyContext(AgencyContext $agencyContext): void
    {
        $this->agencyContext = $agencyContext;
    }

    protected function getCurrentAgency(): Agency
    {
        $agency = $this->agencyContext->getCurrentAgency($this->getUser());

        if (!$agency) {
            throw $this->createNotFoundException('Aucune agence associée à ce compte.');
        }

        $this->denyAccessUnlessGranted('AGENCY_VIEW', $agency);

        return $agency;
    }
}
