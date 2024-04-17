/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your twig elements layout (public.html.twig).
 */



import "./js/admin_dashboard_management"


console.log(window.location.pathname);
if (document.URL.includes('/OfferFunding/')){
    document.getElementById("header").classList.add('header-section-2')
    document.getElementById("header").classList.add('plan-header')
}

$(document).ready(() => {

    // $('#offer_funding_Submit').preventDefault();


    const labelAttribute1 = $("label[for='offer_funding_funding_attribute1']");
    const labelAttribute2 = $("label[for='offer_funding_funding_attribute2']");
    const labelAttribute3 = $("label[for='offer_funding_funding_attribute3']");

    const inputAttribute1 = $('#offer_funding_funding_attribute1')
    const inputAttribute2 = $('#offer_funding_funding_attribute2')
    const inputAttribute3 = $('#offer_funding_funding_attribute3')
    const textAttribute = $('#offer_funding_funding_textattribute')



    $('#Invest').click(() => {
        console.log($('#Invest').data('project-id'));
        labelAttribute1.hide();
        labelAttribute2.hide();
        labelAttribute3.hide();
        inputAttribute1.hide();
        inputAttribute2.hide();
        inputAttribute3.hide();
        textAttribute.hide();
        textAttribute.empty();
    });

    $('#offer_funding_funding_type').change(
        function() {
            labelAttribute1.show();
            labelAttribute2.show();
            labelAttribute3.show();
            inputAttribute1.show();
            inputAttribute2.show();
            inputAttribute3.show();
            textAttribute.show();


        switch ($(this).val()) {
            case 'dept':
                textAttribute.empty();
                labelAttribute2.text("Interest rate");
                labelAttribute3.text("Duration of investment, in years")
                console.log(textAttribute);

                // "AAA", "AA+", "AA", "A+", "A", "BBB+", "BBB", "BB+", "BB
                const options = [
                    { value: '', text: 'Select credit rating', selected: true },
                    { value: 'AAA', text: 'AAA' },
                    { value: 'AA+', text: 'AA+' },
                    { value: 'AA', text: 'AA' },
                    { value: 'A+', text: 'A+' },
                    { value: 'A', text: 'A' },
                    { value: 'BBB+', text: 'BBB+' },
                    { value: 'BBB', text: 'BBB' },
                    { value: 'BB+', text: 'BB+' },
                    { value: 'BB', text: 'BB' }

                ];



                options.forEach(option => {
                    textAttribute.append($('<option>', option));
                });

                break;
            case 'equity':
                textAttribute.empty();
                labelAttribute2.text("Expected return on investment (how much equity %)");
                labelAttribute3.text("Investment horizon in months")

                const options2 = [
                    { value: '', text: 'Select Risk Appetite', selected: true },
                    { value: 'Low', text: 'Low' },
                    { value: 'Medium', text: 'Medium' },
                    { value: 'High', text: 'High' },
                ];



                options2.forEach(option => {
                    textAttribute.append($('<option>', option));
                });
                break;
            case 'revenue':
                textAttribute.empty();
                labelAttribute2.text("percentage of profit");
                labelAttribute3.text("profit margin (%) on product sale")


                const options1 = [
                    { value: '', text: 'Select Revenue Category', selected: true },
                    { value: 'On sails', text: 'On sails' },
                    { value: 'On revenue', text: 'On revenue' },

                ];



                options1.forEach(option => {
                    textAttribute.append($('<option>', option));
                });
                break;

            case '':
                labelAttribute1.hide();
                labelAttribute2.hide();
                labelAttribute3.hide();
                inputAttribute1.hide();
                inputAttribute2.hide();
                inputAttribute3.hide();
                textAttribute.hide();
                break;
        }
    });
//    prevent default
});