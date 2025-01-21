import './bootstrap';

import Alpine from 'alpinejs';

import cookieconsent from 'cookieconsent';
window.addEventListener('load', function () {
    cookieconsent.initialise({
        palette: {
            popup: {
                background: "#000"
            },
            button: {
                background: "#f1d600"
            }
        },
        theme: "classic",
        content: {
            message: "We use cookies to ensure you get the best experience on our website.",
            dismiss: "Got it!",
            link: "Learn more",
            href: "/privacy-policy",
            // Add Terms and Conditions link
            policy: 'Terms and Conditions',
            policyHref: '/terms-and-conditions'
        }
    });
});


window.Alpine = Alpine;
document.querySelector(".cookieconsent-dismiss").addEventListener("click", function () {
    fetch('/cookie-consent', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ consent: true })
    }).then(response => response.json())
      .then(data => console.log(data));
});
document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.dropdown-menu');

    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('mouseenter', () => {
            dropdown.classList.add('show');
        });

        dropdown.addEventListener('mouseleave', () => {
            dropdown.classList.remove('show');
        });
    });
});



Alpine.start();
