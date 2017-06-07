$ = sel => document.getElementById(sel);
function getNumbers() {
  return [].slice
    .call(document.querySelectorAll('[name="numbers[]"]:valid'))
    .map(op => op.value)
    .filter(op => !!op);
}
function serialize(token) {
  let obj = {
    numbers: getNumbers(),
    gametype: document.querySelector('[name="gametype"]:checked').id,
    recaptcha: token
  };
  // console.log(obj);
  return obj;
}
function hideModal() {
  $("modal").className = "";
  $("modal").parentNode.style.display = "none";
}
function showModal(className) {
  if (className) {
    $("modal").className = className;
  }
  $("modal").parentNode.style.display = "block";
}
function updateModal(html, type) {
  $("modal").innerHTML = html;
  showModal(type);
}
function submit(token) {
  const form = serialize(token);
  let data = [];
  for (var key in form) {
    data.push(key + "=" + encodeURIComponent(form[key]));
  }
  const formdata = data.join("&");

  const xhr = new XMLHttpRequest();
  xhr.onload = () => {
    if (xhr.status === 200) {
      const json = JSON.parse(xhr.responseText);
      // prettier-ignore
      updateModal(
        '<p><b>' + json.role.toUpperCase() + '</b></p>'
        + '<p>Texts sent to ' + json.numbers.length + ' players</p>'
        + '<p><small>' + json.numbers.join('<br/>') + '</small></p>'
      );
    } else {
      console.log(xhr);
    }
  };
  xhr.open("POST", "/send.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(formdata);

  $("send").innerHTML = "Send";
  $("send").disabled = false;
  grecaptcha.reset();
}
function cycle() {
  const numbers = getNumbers();
  if (numbers.length < 2) {
    updateModal("Need at least two numbers", "error");
    return false;
  }
  $("send").innerHTML = '<i class="fa fa-spin fa-spinner"></i> Sending';
  $("send").disabled = true;
  setTimeout(() => {
    // In case of modal close
    $("send").innerHTML = "Send";
    $("send").disabled = false;
  }, 2000);
  grecaptcha.execute();
  // Adjust recaptcha position
  setTimeout(() => {
    document.querySelector("body > :last-child").style.top = "50px";
  }, 100);
  return false;
}

function addInput() {
  this.removeEventListener("focus", addInput);
  $("numbers").appendChild(this.cloneNode());
  bindLastInput();
}
function bindLastInput() {
  document
    .querySelector("#numbers input:last-child")
    .addEventListener("focus", addInput, false);
}
