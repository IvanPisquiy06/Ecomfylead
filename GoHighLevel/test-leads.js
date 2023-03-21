let property_ownership = $('#pc01').val()
let electric_bill = $('#electric_bill').val()
let roof_shade = $('#rf2').val()
let first_name = $('#first').val()
let last_name = $('#last').val()
let phone_home = $('#phone').val()
let street = $('#street_number').val()
let email = $('#email').val()
let city = $('#locality').val()
let state = $('#state').val()
let zip = $("#zip").val()
let address = $("#address").val()
let provider = $("#provider-select").val()
let mmm = `provider=${provider}&full_adress=${address}&property_ownership=${property_ownership}&electric_bill=${electric_bill}&roof_shade=${roof_shade}&first_name=${first_name}&last_name=${last_name}&phone_home=${phone_home}&street=${street}&email=${email}&city=${city}&state=${state}&zip=${zip}&solar_electric=true&ip_address=${ipadr}&xxTrustedFormCertUrl=${document.querySelector("#xxTrustedFormCertUrl_0").value}`;
$.ajax({
        type: "POST",
        url: "/papi/submit.php?",
        data: mmm,
        timeout: 30000,
        error: function() {
            pollForSuccess(0, success);
        }
    })