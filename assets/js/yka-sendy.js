const checkElement = async (selector) => {
  while (document.querySelector(selector) === null) {
    await new Promise((resolve) => requestAnimationFrame(resolve));
  }
  return document.querySelector(selector);
};

checkElement('[data-behaviour="yka-sendy-form"]').then((formElement) => {
  formElement.addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = new URLSearchParams(); // to convert multipart-form into x-www-url-encoded

    for (const pair of formData) {
      data.append(pair[0], pair[1]);
    }

    let response = await fetch(this.getAttribute("action"), {
      method: "post",
      body: data,
    });

    let message = await response.text();
    const status = document.getElementById("sendy-status");
    if (message == 1) {
      status.innerHTML = "You're subscribed to our mailing list. Thank You!";
    } else {
      status.innerHTML = message;
    }
  });
});
