const send_email_button = document.querySelector('#send-email');


send_email_button.addEventListener('click', async (e) => {
    // console.log(document.querySelector('#email').value);
    const request = await get_formchangepassword('https://shinon.altervista.org/MyProject/password-recovery.php', document.querySelector('#email').value, 'https://shinon.altervista.org/MyProject/frontend/change-password.php');
  })

async function get_formchangepassword(url, email, redirectURL){

    const myURL = url + "?email=" + email + "&url=" + redirectURL;

    const res_otp = await fetch(myURL, { 
        method: "GET",
        headers: { 'Content-Type': 'application/json' }
    });

    resp_otp = await res_otp.json();
    console.log(resp_otp);
}