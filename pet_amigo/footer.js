const year = new Date().getFullYear();
const contactInfo = 'petamigotwentythree@gmail.com';

document.addEventListener('DOMContentLoaded', function() {
  const footerContainer = document.getElementById('footer-container');
  const footerContent = `
    <div class="container">
      <p>Contact: ${contactInfo}</p>
      <p>&copy; ${year} Pet Amigo. All rights reserved.</p>
    </div>
  `;
  footerContainer.innerHTML = footerContent;
});
