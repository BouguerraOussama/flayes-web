/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your twig elements layout (public.html.twig).
 */




console.log(window.location.pathname);
if (document.URL.includes('/OfferFunding/')){
    document.getElementById("header").classList.add('header-section-2')
    document.getElementById("header").classList.add('plan-header')
}

$(document).ready(()=>{
    $()
})