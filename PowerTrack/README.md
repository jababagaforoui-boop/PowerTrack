# PowerTrack - Home & Office Energy Monitoring Web App

## Description
PowerTrack is a web-based application that allows users to monitor and track electricity consumption of their home or office appliances in real-time. Users can manage appliances, log usage, view dashboards with charts, receive alerts for high consumption, and generate reports (PDF/Excel).

## Features
- User registration, login, and profile management
- Add, edit, and delete appliances
- Input daily or real-time energy usage
- Interactive dashboard with energy charts
- Highlight high-usage appliances
- Generate downloadable reports (Excel/PDF)
- Secure with input sanitization and CSRF protection

## Tech Stack
- Frontend: HTML5, CSS3, JavaScript, Tailwind (optional), Chart.js
- Backend: PHP, PDO
- Database: MySQL
- Reports: PHPSpreadsheet (Excel), FPDF (PDF)

## Setup Instructions
1. Clone repository to local server (XAMPP/WAMP/LAMP)
2. Import `powertrack.sql` database
3. Update `backend/config/db.php` with your database credentials
4. Install Composer dependencies (for reports):
   ```bash
   composer require phpoffice/phpspreadsheet
   composer require fpdf/fpdf