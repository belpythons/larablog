# LaraBlog // Developer Documentation Hub

A production-grade developer documentation system built with **Laravel 12** and **Filament PHP**. Features a distinct **Neo-Brutalist** design language and a terminal-inspired landing page.

![LaraBlog Terminal](https://via.placeholder.com/1200x600?text=LaraBlog+Terminal+UI)

## 🚀 Key Features

### 🎨 Neo-Brutalist Frontend
- **Terminal Landing Page**: Interactive CLI-style entry point with ASCII art and system stats.
- **Brutalist UI Kit**: High-contrast design, bold borders, hard shadows, and vibrant accent colors (Yellow/Green/Blue/Purple).
- **Spotlight Search**: Global command palette (`Cmd+K` / `Ctrl+K`) for instant navigation.
- **Livewire SPA**: Seamless page transitions using `wire:navigate`.
- **Smart Changelog**: Inline expandable release notes with direct links to documentation.

### 📚 Documentation Engine
- **Three-Pillar Structure**:
  - 🔵 **Ecosystem**: Conceptual guides and decision-making frameworks.
  - 🟢 **Starter Kits**: "How-to" tutorials and boilerplate setups.
  - 🟠 **The Bricks**: Reusable UI components with live previews and copy-paste Blade snippets.
- **Versioning Support**: Multi-version documentation support (e.g., v10.x, v11.x).
- **Reading Experience**: Sticky Table of Contents, Reading time progress, and "Theory vs Technical" split views.

### ⚙️ Production-Grade Admin Panel
- **Powered by Filament v4**: Latest version of the TALL-stack admin panel.
- **Dynamic Dashboard**: Real-time stats, publishing trends chart, and recent activity.
- **Advanced Editor**:
  - **SEO Optimization**: Live character counters for Meta Title/Description, OG Image support.
  - **AI Integration**: Placeholder actions for "Magic Summary" generation.
  - **Tabs Layout**: Clean separation of Content, Troubleshooting, and SEO fields.
- **Monitoring Ready**: Structure prepared for `spatie/laravel-activitylog` and `spatie/laravel-health`.

## 🛠 Tech Stack

- **Framework**: Laravel 12.x
- **Admin Panel**: Filament 4.x
- **Frontend**: Blade + Livewire 3
- **Styling**: Tailwind CSS (Custom Neo-Brutalist Config)
- **Typography**: JetBrains Mono (Google Fonts)
- **Interactivity**: Alpine.js

## 📦 Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd larablog
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

4. **Database Setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Build & Serve**
   ```bash
   npm run build
   php artisan serve
   ```

## 🔐 Admin Access

After seeding, access the admin panel at `/admin`:

- **URL**: `http://localhost:8000/admin`
- **Email**: `admin@larablog.com` (check `DatabaseSeeder.php` for defaults)
- **Password**: `password`

## 🤝 Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
