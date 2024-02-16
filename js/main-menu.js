const title = document.getElementById("title");
const text = "Welcome to AProject"; // The text to be typed

let i = 0; // Current index in the text
const speed = 50; // Typing speed (in milliseconds)

function typeWriter() {
  if (i < text.length) {
    title.innerHTML += text.charAt(i);
    i++;
    setTimeout(typeWriter, speed);
  }
}

// Start the typing animation on page load
window.addEventListener("load", () => {
  typeWriter();
});