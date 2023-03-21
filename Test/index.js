/*Getting the values of the form*/
const form = document.getElementById("ping-post-form");
/*Setting constants with the URL's and header for the token*/
const apiUrlPing = "https://test-api.jangl.com/v2/solar/ping";
const apiUrlPost = "https://test-api.jangl.com/v2/solar/post";
const apiURLDirect = "https://test-api.jangl.com/v2/solar/direct_post";
const token = "7f9cdaa692c25448598e7450195274c18da7f57c";
const apiHeader = {
  Authorization: `Token ${token}`,
  "Content-Type": "application/json",
  Accept: "application/json",
};

/*Starting the listener for the button on the HTML*/
form.addEventListener("submit", async (event) => {
  event.preventDefault();

  var currentDateTime = new Date();

  try {
    // Ping Request
    const pingResponse = await fetch(apiUrlPing, {
      method: "POST",
      headers: apiHeader,
      /*Setting the Json sintax to be received and sent*/
      body: JSON.stringify({
        meta: {
          originaly_created: currentDateTime.toLocaleString(),
          source_id: "1A2B3C4D",
          offer_id: "13502",
          lead_id_code: "4xyz78b9-0cdc-43a7-98ea-2b680a5313a2",
          trusted_form_cert_url: "https://cert.trustedform.com/f886071",
          user_agent:
            "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko)Chrome/51.0.2704.103 Safari/537.36",
          landing_page_url: "https://www.somewebsite.com",
          tcpa_compliant: Boolean,
          tcpa_compliant_text:
            "I agree to receive to be contacted by phone or email.",
        },
        contact: {
          phone_last_four: form.elements.telephone.value.slice(-4),
          zip_code: form.elements.zip_code.value,
          ip_address: "10.0.0.1",
        },
        data: {
          best_call_time: "Any Time",
          own_property: true,
          purchase_time_frame: form.elements.purchase_time.value,
          monthly_electric_bill: 400,
          utility_provider: "Southern California Edison",
          roof_shade: form.elements.roof_shade.value,
          property_type: form.elements.property_type.value,
          credit_rating: form.elements.credit_rating.value,
        },
      }),
    });

    const pingJson = await pingResponse.json();
    console.log(pingJson);
    const authCode = pingJson.authCode;

    // Post Request
    const postResponse = await fetch(apiUrlPost, {
      method: "POST",
      headers: apiHeader,
      body: JSON.stringify({
        auth_code: `${authCode}`,
        meta: {
          originaly_created: currentDateTime.toLocaleString(),
          source_id: "1A2B3C4D",
          offer_id: "13502",
          lead_id_code: "4xyz78b9-0cdc-43a7-98ea-2b680a5313a2",
          trusted_form_cert_url: "https://cert.trustedform.com/f886071",
          user_agent:
            "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko)Chrome/51.0.2704.103 Safari/537.36",
          landing_page_url: "https://www.somewebsite.com",
          tcpa_compliant: Boolean,
          tcpa_compliant_text:
            "I agree to receive to be contacted by phone or email.",
        },
        contact: {
          first_name: form.elements.first_name.value,
          last_name: form.elements.last_name.value,
          email: form.elements.email.value,
          phone: form.elements.telephone.value,
          address: form.elements.address.value,
          city: form.elements.city.value,
          state: form.elements.state.value,
          zip_code: form.elements.zip_code.value,
          ip_address: "10.0.0.1",
        },
        data: {
          best_call_time: "Any Time",
          own_property: true,
          purchase_time_frame: form.elements.purchase_time.value,
          monthly_electric_bill: 400,
          utility_provider: "Southern California Edison",
          roof_shade: form.elements.roof_shade.value,
          property_type: form.elements.property_type.value,
          credit_rating: form.elements.credit_rating.value,
        },
      }),
    });

    const postJson = await postResponse.json();

    if (postJson.status == "success") {
      console.log(postJson);
    } else if (postJson.status == "re-ping") {
      console.log(
        "Buyer is no longer available. Please resend lead to Ping to obtain new Auth Code"
      );
    } else {
      console.log(`Denied: ${postJson.reason}`);
      console.log(postJson);
    }
  } catch (error) {
    console.error(error);
  }

  const DirectPostResponse = await fetch(apiURLDirect, {
    method: "POST",
    headers: apiHeader,
    body: JSON.stringify({
      meta: {
        originaly_created: currentDateTime.toLocaleString(),
        source_id: "1A2B3C4D",
        offer_id: "13502",
        lead_id_code: "4xyz78b9-0cdc-43a7-98ea-2b680a5313a2",
        trusted_form_cert_url: "https://cert.trustedform.com/f886071",
        user_agent:
          "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko)Chrome/51.0.2704.103 Safari/537.36",
        landing_page_url: "https://www.somewebsite.com",
        tcpa_compliant: Boolean,
        tcpa_compliant_text:
          "I agree to receive to be contacted by phone or email.",
      },
      contact: {
        first_name: form.elements.first_name.value,
        last_name: form.elements.last_name.value,
        email: form.elements.email.value,
        phone: form.elements.telephone.value,
        address: form.elements.address.value,
        city: form.elements.city.value,
        state: form.elements.state.value,
        zip_code: form.elements.zip_code.value,
        ip_address: "10.0.0.1",
      },
      data: {
        best_call_time: "Any Time",
        own_property: true,
        purchase_time_frame: form.elements.purchase_time.value,
        monthly_electric_bill: 400,
        utility_provider: "Southern California Edison",
        roof_shade: form.elements.roof_shade.value,
        property_type: form.elements.property_type.value,
        credit_rating: form.elements.credit_rating.value,
      },
    }),
  });

  const DirectJson = await DirectPostResponse.json();
  console.log(DirectJson);
});
