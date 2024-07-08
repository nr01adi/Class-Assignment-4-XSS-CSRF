# Class-Assignment-4---XSS-CSRF

Content Security Policy (CSP):
- Added the <meta http-equiv="Content-Security-Policy"> tag to the HTML <head> section to enforce the CSP.

Cross-Site Scripting (XSS) Prevention:
- Used htmlspecialchars() to sanitize user inputs before using them in SQL queries or displaying them in the HTML.

Cross-Site Request Forgery (CSRF) Protection:
- Generated a CSRF token and included it as a hidden input in forms.
- alidated the CSRF token on the server side before processing the form data.
