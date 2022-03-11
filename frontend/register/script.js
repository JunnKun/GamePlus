async function iflog(url){

    const res_otp = await fetch(url, { 
        method: "GET",
        headers: { 'Content-Type': 'application/json' }
    });
    resp_otp = await res_otp.json();
    console.log(resp_otp);

    if(!resp_otp.error){
        window.location.href = 'http://shinon.altervista.org/MyProject/frontend/home.php';
    }
}

function submitForm(event){
    event.preventDefault();
    window.history.back();
  }