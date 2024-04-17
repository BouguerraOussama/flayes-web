$(document).ready(()=>{
    if (document.URL.includes('/admin')){
        if(document.URL.includes('/OfferFunding')){
            $('ul.dashboard-menu > li > a').removeClass('active');
            $('ul.dashboard-menu > li > a:nth-child(2)').addClass('active');
        }
    }
    }
)

