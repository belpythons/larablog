# Belpythons Portfolio

A modern, interactive portfolio application built with Laravel 11, showcasing advanced frontend techniques and dynamic feature generation.

## 🚀 Key Features

### 🎨 Live Custom Theme Builder
- **Real-time Customization**: Users can modify the site's accent colors, background tones, and typography.
- **Font Selection**: Choose from a curated list of Google Fonts (Instrument Sans, Inter, Roboto, Playfair Display, JetBrains Mono, etc.).
- **Persisted Settings**: Preferences are saved to `localStorage` and persist across page reloads.
- **Collapsible UI**: A sleek, non-intrusive floating panel for customization.

### 📄 ATS-Friendly Resume Export
- **Dynamic PDF Generation**: Generates a clean, ATS-optimized resume directly from the portfolio data.
- **Standardized Format**: Uses a Harvard/Simple layout ensuring maximum compatibility with Applicant Tracking Systems.
- **One-Click Download**: Accessible directly from the Theme Builder panel.

### 💎 Design Aesthetics
- **Brutalism meets Abstract**: A unique blend of bold typography and abstract animated elements (`x-ui.blob`).
- **Glassmorphism**: Modern UI components with backdrop blur and transparency.
- **Responsive Grid**: Sophisticated background patterns adapting to theme changes.

## 🛠 Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade, Tailwind CSS v4 (via Vite), Alpine.js
- **PDF Generation**: `barryvdh/laravel-dompdf`
- **Database**: SQLite / MySQL

## 📦 Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laravel-porto
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Migration**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Build Assets & Serve**
   ```bash
   npm run build
   php artisan serve
   ```

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
