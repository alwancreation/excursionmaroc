/*! jQuery Mobile v1.2.0 jquerymobile.com | jquery.org/license */
(function(a,b,c){typeof define=="function"&&define.amd?define(["jquery"],function(d){return c(d,a,b),d.mobile}):c(a.jQuery,a,b)})(this,document,function(a,b,c,d){(function(a,b){var d={touch:"ontouchend"in c};a.mobile=a.mobile||{},a.mobile.support=a.mobile.support||{},a.extend(a.support,d),a.extend(a.mobile.support,d)})(a),function(a,b,c,d){function x(a){while(a&&typeof a.originalEvent!="undefined")a=a.originalEvent;return a}function y(b,c){var e=b.type,f,g,i,k,l,m,n,o,p;b=a.Event(b),b.type=c,f=b.originalEvent,g=a.event.props,e.search(/^(mouse|click)/)>-1&&(g=j);if(f)for(n=g.length,k;n;)k=g[--n],b[k]=f[k];e.search(/mouse(down|up)|click/)>-1&&!b.which&&(b.which=1);if(e.search(/^touch/)!==-1){i=x(f),e=i.touches,l=i.changedTouches,m=e&&e.length?e[0]:l&&l.length?l[0]:d;if(m)for(o=0,p=h.length;o<p;o++)k=h[o],b[k]=m[k]}return b}function z(b){var c={},d,f;while(b){d=a.data(b,e);for(f in d)d[f]&&(c[f]=c.hasVirtualBinding=!0);b=b.parentNode}return c}function A(b,c){var d;while(b){d=a.data(b,e);if(d&&(!c||d[c]))return b;b=b.parentNode}return null}function B(){r=!1}function C(){r=!0}function D(){v=0,p.length=0,q=!1,C()}function E(){B()}function F(){G(),l=setTimeout(function(){l=0,D()},a.vmouse.resetTimerDuration)}function G(){l&&(clearTimeout(l),l=0)}function H(b,c,d){var e;if(d&&d[b]||!d&&A(c.target,b))e=y(c,b),a(c.target).trigger(e);return e}function I(b){var c=a.data(b.target,f);if(!q&&(!v||v!==c)){var d=H("v"+b.type,b);d&&(d.isDefaultPrevented()&&b.preventDefault(),d.isPropagationStopped()&&b.stopPropagation(),d.isImmediatePropagationStopped()&&b.stopImmediatePropagation())}}function J(b){var c=x(b).touches,d,e;if(c&&c.length===1){d=b.target,e=z(d);if(e.hasVirtualBinding){v=u++,a.data(d,f,v),G(),E(),o=!1;var g=x(b).touches[0];m=g.pageX,n=g.pageY,H("vmouseover",b,e),H("vmousedown",b,e)}}}function K(a){if(r)return;o||H("vmousecancel",a,z(a.target)),o=!0,F()}function L(b){if(r)return;var c=x(b).touches[0],d=o,e=a.vmouse.moveDistanceThreshold,f=z(b.target);o=o||Math.abs(c.pageX-m)>e||Math.abs(c.pageY-n)>e,o&&!d&&H("vmousecancel",b,f),H("vmousemove",b,f),F()}function M(a){if(r)return;C();var b=z(a.target),c;H("vmouseup",a,b);if(!o){var d=H("vclick",a,b);d&&d.isDefaultPrevented()&&(c=x(a).changedTouches[0],p.push({touchID:v,x:c.clientX,y:c.clientY}),q=!0)}H("vmouseout",a,b),o=!1,F()}function N(b){var c=a.data(b,e),d;if(c)for(d in c)if(c[d])return!0;return!1}function O(){}function P(b){var c=b.substr(1);return{setup:function(d,f){N(this)||a.data(this,e,{});var g=a.data(this,e);g[b]=!0,k[b]=(k[b]||0)+1,k[b]===1&&t.bind(c,I),a(this).bind(c,O),s&&(k.touchstart=(k.touchstart||0)+1,k.touchstart===1&&t.bind("touchstart",J).bind("touchend",M).bind("touchmove",L).bind("scroll",K))},teardown:function(d,f){--k[b],k[b]||t.unbind(c,I),s&&(--k.touchstart,k.touchstart||t.unbind("touchstart",J).unbind("touchmove",L).unbind("touchend",M).unbind("scroll",K));var g=a(this),h=a.data(this,e);h&&(h[b]=!1),g.unbind(c,O),N(this)||g.removeData(e)}}}var e="virtualMouseBindings",f="virtualTouchID",g="vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),h="clientX clientY pageX pageY screenX screenY".split(" "),i=a.event.mouseHooks?a.event.mouseHooks.props:[],j=a.event.props.concat(i),k={},l=0,m=0,n=0,o=!1,p=[],q=!1,r=!1,s="addEventListener"in c,t=a(c),u=1,v=0,w;a.vmouse={moveDistanceThreshold:10,clickDistanceThreshold:10,resetTimerDuration:1500};for(var Q=0;Q<g.length;Q++)a.event.special[g[Q]]=P(g[Q]);s&&c.addEventListener("click",function(b){var c=p.length,d=b.target,e,g,h,i,j,k;if(c){e=b.clientX,g=b.clientY,w=a.vmouse.clickDistanceThreshold,h=d;while(h){for(i=0;i<c;i++){j=p[i],k=0;if(h===d&&Math.abs(j.x-e)<w&&Math.abs(j.y-g)<w||a.data(h,f)===j.touchID){b.preventDefault(),b.stopPropagation();return}}h=h.parentNode}}},!0)}(a,b,c),function(a,b,d){function j(b,c,d){var e=d.type;d.type=c,a.event.handle.call(b,d),d.type=e}a.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight scrollstart scrollstop".split(" "),function(b,c){a.fn[c]=function(a){return a?this.bind(c,a):this.trigger(c)},a.attrFn&&(a.attrFn[c]=!0)});var e=a.mobile.support.touch,f="touchmove scroll",g=e?"touchstart":"mousedown",h=e?"touchend":"mouseup",i=e?"touchmove":"mousemove";a.event.special.scrollstart={enabled:!0,setup:function(){function g(a,c){d=c,j(b,d?"scrollstart":"scrollstop",a)}var b=this,c=a(b),d,e;c.bind(f,function(b){if(!a.event.special.scrollstart.enabled)return;d||g(b,!0),clearTimeout(e),e=setTimeout(function(){g(b,!1)},50)})}},a.event.special.tap={tapholdThreshold:750,setup:function(){var b=this,d=a(b);d.bind("vmousedown",function(e){function i(){clearTimeout(h)}function k(){i(),d.unbind("vclick",l).unbind("vmouseup",i),a(c).unbind("vmousecancel",k)}function l(a){k(),f===a.target&&j(b,"tap",a)}if(e.which&&e.which!==1)return!1;var f=e.target,g=e.originalEvent,h;d.bind("vmouseup",i).bind("vclick",l),a(c).bind("vmousecancel",k),h=setTimeout(function(){j(b,"taphold",a.Event("taphold",{target:f}))},a.event.special.tap.tapholdThreshold)})}},a.event.special.swipe={scrollSupressionThreshold:30,durationThreshold:1e3,horizontalDistanceThreshold:30,verticalDistanceThreshold:75,setup:function(){var b=this,c=a(b);c.bind(g,function(b){function j(b){if(!f)return;var c=b.originalEvent.touches?b.originalEvent.touches[0]:b;g={time:(new Date).getTime(),coords:[c.pageX,c.pageY]},Math.abs(f.coords[0]-g.coords[0])>a.event.special.swipe.scrollSupressionThreshold&&b.preventDefault()}var e=b.originalEvent.touches?b.originalEvent.touches[0]:b,f={time:(new Date).getTime(),coords:[e.pageX,e.pageY],origin:a(b.target)},g;c.bind(i,j).one(h,function(b){c.unbind(i,j),f&&g&&g.time-f.time<a.event.special.swipe.durationThreshold&&Math.abs(f.coords[0]-g.coords[0])>a.event.special.swipe.horizontalDistanceThreshold&&Math.abs(f.coords[1]-g.coords[1])<a.event.special.swipe.verticalDistanceThreshold&&f.origin.trigger("swipe").trigger(f.coords[0]>g.coords[0]?"swipeleft":"swiperight"),f=g=d})})}},a.each({scrollstop:"scrollstart",taphold:"tap",swipeleft:"swipe",swiperight:"swipe"},function(b,c){a.event.special[b]={setup:function(){a(this).bind(c,a.noop)}}})}(a,this)});




function hp_map_change_image(num_region){
	$("#region-map").attr("class","sprite_region_"+num_region);
	
}

function goToByScroll(id){
    $('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');
}



function openFormEditLogin(){
	$('#form_edit_ad').slideDown(300);
	$('#link_edit_ad').fadeOut();
	return false;

} 


function setCatScat(select){
	var type=$(select).find(':selected').data('type');
	if (type=='scat') {
		$(select).attr('name','scid');
	}else{
		$(select).attr('name','cid');
	};
}


function contactSeller(){
	$('.form-contact-seller').addClass('contact-loading');

	var name=$('#art_name').val();
	var phone=$('#art_phone').val();
	var mail=$('#art_mail').val();
	var message=$('#art_message').val();
	var id=$('#article_id').val();

	$.ajax({
		url: '/article/contact',
		type: 'POST',
		dataType: 'json',
		data: {
			id: id,
			name: name,
			phone: phone,
			mail: mail,
			message: message,
		},
		success:function(response){
			if (response.success==1) {
				$('.form-contact-seller').addClass('contact-ok');
				$('.form-contact-seller').reset();
			}else{
				$('.form-contact-seller').removeClass('contact-ok');
				$('.form-contact-seller').removeClass('contact-loading');
			};
		}
	});
	return false;
}





function validateFSI1(){
	if($("#marque_si option:selected").val()==0){
		alert("Veuillez choisir la marque de votre vehicule");
		$("#marque_si").focus();
		return false;
	}
	if($("#modele_si option:selected").val()==0){
		alert("Veuillez choisir le modele de votre vehicule");
		$("#modele_si").focus();
		return false;
	}
	if($("#mois_si option:selected").val()==0){
		alert("Veuillez choisir le mois !");
		$("#mois_si").focus();
		return false;
	}
	if($("#annee_si option:selected").val()==0){
		alert("Veuillez choisir l'année !");
		$("#annee_si").focus();
		return false;
	}
	if($("#carburant_si option:selected").val()==0){
		alert("Veuillez choisir le carburant !");
		$("#carburant_si").focus();
		return false;
	}
	return true;
}

function deleteImg(id_image){
	$.ajax({
   		type: "POST",
  		url: "/publish/delete",
  		dataType: "json",
   		data: {op:"delimg",id_img:id_image},
   		success: function(response){
			if(response.success==1){
				$("#img_min_"+response.id).fadeOut(400, function() {
					$(this).remove();
				});;
				return false;
			}
   		}
 	});
 	return false;
}

var next_function_popup='';

function getPrice(){
	$.ajax({
		url: '/app_dev.php/remote/price',
		type: 'POST',
		dataType: 'json',
		data: {
			id: $('#product_id').val(),
			adults: $('#nbr_adults').val(),
			children: $('#nbr_child').val()
		},
		success: function (response) {
			console.log(response);
		}
	});
}

$(document).ready(function(e) {

	//$('.datepicker').datepicker();
	/*  FullScreen slider
	 ================================================*/
	if($("#fullscreen-slider").length > 0 ){

		$("#fullscreen-slider").maximage({
            fillElement: '#home-slider',
            backgroundSize: 'contain',
			cycleOptions: {
				fx: 'fade',
				// Speed has to match the speed for CSS transitions
				speed: 1500,
				timeout: 5500,
				prev: '#arrow_left',
				next: '#arrow_right',
				pause: 0,
				before: function(last,current){
					// $(".animate").remove("animated") ;
				},

				after: function(last,current){

				}
			},

			onFirstImageLoaded: function(){

			}

		});
	}

	$("svg path").on("click",function(evt){
		window.location.href = "/list";
	});
	$("svg path").hover(function(evt){
		$("#region-name").html($(this).attr("title"));
	});

	$('#photoimg').on('change', function(){ 
		$("#loading_imgs").html('<div class="bs-example" data-example-id="animated-progress-bar"><div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 99%"><span class="sr-only">99% Complete</span></div></div>');
		$("#imageform").ajaxForm({
			target: '#preview_img',
			success: showResponse
		}).submit();
	});
	
	photoimgCLK=function(){
		$("#photoimg").trigger("click");
		return false;
	}
	
	
	showResponse = function (responseText, statusText, xhr, $form) {
		$("#loading_imgs").html('');


		$('.cd-popup-trigger').on('click', function(event){
		event.preventDefault();
			next_function_popup=$(this).data('function');
			$('.cd-popup').addClass('is-visible');
		});
		
		//close popup
		$('.cd-popup').on('click', function(event){
			if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup')  || $(event.target).is('.cd-popup-no') ) {
				event.preventDefault();
				$(this).removeClass('is-visible');
			};
			if ($(event.target).is('.cd-popup-yes')) {
				event.preventDefault();
				$(this).removeClass('is-visible');
				if (next_function_popup!='') {
					setTimeout(next_function_popup,10);
				};
			};
		});

		//close popup when clicking the esc keyboard button
		$(document).keyup(function(event){
	    	if(event.which=='27'){
	    		$('.cd-popup').removeClass('is-visible');
		    }
	    });

	}
	
	
	
});

/////////////////////////////////////////////////////
// popup confirmation 
/////////////////////////////////////////////////////
jQuery(document).ready(function($){
	//open popup
	$('.cd-popup-trigger').on('click', function(event){
		event.preventDefault();
		next_function_popup=$(this).data('function');
		$('.cd-popup').addClass('is-visible');
	});
	
	//close popup
	$('.cd-popup').on('click', function(event){
		if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup')  || $(event.target).is('.cd-popup-no') ) {
			event.preventDefault();
			$(this).removeClass('is-visible');
		};
		if ($(event.target).is('.cd-popup-yes')) {
			event.preventDefault();
			$(this).removeClass('is-visible');
			if (next_function_popup!='') {
				setTimeout(next_function_popup,10);
			};
		};
	});

	//close popup when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$('.cd-popup').removeClass('is-visible');
	    }
    });







    $("#carousel-example-generic").swiperight(function() {  
      $("#carousel-example-generic").carousel('prev');  
    });  
   $("#carousel-example-generic").swipeleft(function() {  
      $("#carousel-example-generic").carousel('next');  
   });  

});