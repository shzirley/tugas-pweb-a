// Animasi kecil pas tombol diklik
document.addEventListener("DOMContentLoaded", () => {
  const button = document.querySelector("button");

  if (button) {
    button.addEventListener("click", () => {
      button.innerText = "Clicked!";
      button.style.backgroundColor = "#28a745"; // hijau sukses
      setTimeout(() => {
        button.innerText = "Click Me";
        button.style.backgroundColor = "#1e90ff";
      }, 1500);
    });
  }
});
