/*Getting the values of the form*/
const form = document.getElementById("ping-post-form");
/*Setting constants with the URL's and header for the token*/
const apiUrlPing = "https://leads-inst338-client.phonexa.com/ping/";
const apiUrlPost = "https://leads-inst338-client.phonexa.com/post/";
const apiURLDirect = "https://leads-inst338-client.phonexa.com/fullpost/";
const apiHeader = {
  "Content-Type": "application/json",
  Accept: "application/json",
};

/*Starting the listener for the button on the HTML*/
form.addEventListener("submit", async (event) => {
  event.preventDefault();

  try {
    // Ping Request
    const pingResponse = await fetch(apiUrlPing, {
      mode: "cors",
      method: "POST",
      headers: apiHeader,
      /*Setting the Json sintax to be received and sent*/
      body: JSON.stringify({
        apiId: "2104CDAB524B4FF0AD65526E286DA5DC",
        apiPassword: "d27589572",
        productId: 177,
        trustedForm: "https://cert.trustedform.com/454a35b802f3e7b63ffabb4efedb7c6ebe67886c",
        jornayaLeadId: "",
        tcpa: "YES",
        tcpaLanguage: "I agree to Terms, Privacy, and consent to solar/home servicers to send marketing prerecorded messages and autodialed calls/texts to my phone number above even if it's on any do not call list. Consent is not a condition of purchase. You can opt-out at any time (see Terms). Message/data rates may apply.",
        webSiteUrl: "https://gogreenandsave.net/",
        urlConsent: "https://gogreenandsave.net/",
        address: form.elements.address.value,
        zip: form.elements.zip_code.value,
        city: form.elements.city.value,
        state: form.elements.state.value,
        ownHome: "YES",
        monthlyBill: 150,
        propertyType: "SINGLE_FAMILY",
        roofType: "UNSURE_OTHER",
        roofShade: "NO_SHADE",
        creditRating: "EXCELLENT",
        purchaseTimeFrame: "IMMEDIATELY",
        userIp: "10.0.0.1",
        projectType: "NEW",
        solarSystemType: "ELECTRICITY"
      }),
    });

    const pingJson = await pingResponse.json();
    console.log(pingJson);
    const promise = pingJson.promise;
    console.log(promise);

    // Post Request
    const postResponse = await fetch(apiUrlPost, {
      method: "POST",
      headers: apiHeader,
      body: JSON.stringify({
        auth_code: `${promise}`,
        apiId: "2104CDAB524B4FF0AD65526E286DA5DC",
        apiPassword: "d27589572",
        productId: 177,
        trustedForm: "https://cert.trustedform.com/454a35b802f3e7b63ffabb4efedb7c6ebe67886c",
        jornayaLeadId: "",
        tcpa: "YES",
        tcpaLanguage: "I agree to Terms, Privacy, and consent to solar/home servicers to send marketing prerecorded messages and autodialed calls/texts to my phone number above even if it's on any do not call list. Consent is not a condition of purchase. You can opt-out at any time (see Terms). Message/data rates may apply.",
        webSiteUrl: "https://gogreenandsave.net/",
        urlConsent: "https://gogreenandsave.net/",
        firstName: form.elements.first_name,
        lastName: form.elements.last_name,
        email: form.elements.email,
        mobilePhone: form.elements.telephone,
        address: form.elements.address.value,
        zip: form.elements.zip_code.value,
        city: form.elements.city.value,
        state: form.elements.state.value,
        ownHome: "YES",
        monthlyBill: 150,
        propertyType: "SINGLE_FAMILY",
        roofType: "UNSURE_OTHER",
        roofShade: "NO_SHADE",
        creditRating: "EXCELLENT",
        purchaseTimeFrame: "IMMEDIATELY",
        userIp: "10.0.0.1",
        projectType: "NEW",
        solarSystemType: "ELECTRICITY"
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
});
