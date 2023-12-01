let menu = document.querySelector('#menu-icon');
let navlist = document.querySelector('.navlist');

menu.onclick = () => {
    menu.classList.toggle('bx-x');
    navlist.classList.toggle('open');
};

const sr = ScrollReveal ({
    distance: '65px',
    duration: 2600,
    delay: 450,
    reset: true
});

sr.reveal('.bank-text',{delay:200, origin:'top'});
sr.reveal('.bank-img',{delay:450, origin:'top'});
sr.reveal('.scroll-down',{delay:500, origin:'right'});
sr.reveal('.bank-login',{delay:200, origin:'top'});
sr.reveal('.bank-text-dashboard',{delay:200, origin:'top'});
sr.reveal('.container',{delay:200, origin:'top'});
sr.reveal('.atm',{delay:200, origin:'top'});

function openPopOutWindow() {
  var url = 'registration.html';
  var width = 550;
  var height = 550;
  var left = (screen.width - width) / 2;
  var top = (screen.height - height) / 2 + -60;

  window.open(url, 'PopOutWindow', 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top);
}


function submit() {
  const cardNumber = document.getElementById("debitcard").value;
  const pin = document.getElementById("Pin").value;

  // Make an AJAX request to submit the form data
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "/atm.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.success) {
        showGreetingMessage(response.greetingMessage);
        document.getElementById("cardBox").style.display = "block";
        document.getElementById("buttonsContainer").style.display = "block";
      } else {
        alert("Card Number or PIN is incorrect!");
      }
    }
  };
  
  // Send the form data
  const formData = `debitcard=${cardNumber}&Pin=${pin}`;
  xhr.send(formData);
}
document.getElementById("cancel").addEventListener("click", function () {
  resetATM();
});

function resetATM() {
  const atmScreen = document.getElementById("atmScreen");
  const buttonsContainer = document.getElementById("buttonsContainer");

  document.getElementById("cardNumber").value = "";
  document.getElementById("pin").value = "";

  atmScreen.style.display = "block";
  cardBox.style.display = "none";
  buttonsContainer.style.display = "none";
}