# Safenix — Real-Time Disaster Monitoring & Reporting Platform

## Project Overview
A Laravel 11 + Inertia.js + Vue 3 platform for disaster reporting, admin verification, live mapping, emergency alerts, rescue team management, and news publishing for Bangladesh.

**Team:** Nurnahar Nuri (210147) & Riazul Islam Mubin (210161) — DIIT, CSE

## Tech Stack
- **Backend:** Laravel 11, PHP 8.4
- **Frontend:** Vue 3 (Composition API) + Inertia.js + Tailwind CSS + Vite
- **Database:** MySQL
- **Auth:** Laravel Breeze (Inertia-Vue) + spatie/laravel-permission (3 roles: admin, responder, user)
- **Real-time:** Laravel Reverb + Laravel Echo (WebSockets)
- **Maps:** Google Maps JS API
- **Email:** Gmail SMTP (queued via database driver)
- **Media:** Local public disk (dev), S3 (prod)

## Project Structure
```
app/
  Http/Controllers/
    ReportController.php          # User: submit report, my reports
    LiveMapController.php         # Public live map + JSON feed
    NewsController.php            # Public news listing + single article
    NotificationController.php    # User notifications
    Admin/
      ReportController.php        # Verify/reject reports
      AlertController.php         # Emergency alerts
      RescueTeamController.php    # Team CRUD
      AssignmentController.php    # Assign team to incident
      NewsController.php          # Article CRUD + convert report to article
    Responder/
      AssignmentController.php    # View & update assignment status
  Events/
    ReportVerified.php            # Broadcasts to 'incidents' channel
  Jobs/
    NotifyRescueTeam.php          # Queued: emails all team members
  Mail/
    RescueAssignmentMail.php      # Markdown email to rescue team
  Notifications/
    ReportApproved.php            # database + broadcast
    ReportRejected.php            # database + broadcast
    EmergencyAlert.php            # database + broadcast
  Models/
    User, Report, ReportMedia, Category, District, Upazila,
    RescueTeam, RescueTeamMember, TeamAssignment, Alert, NewsArticle
  Services/
    MediaService.php              # File upload + thumbnails
resources/js/
  Pages/
    Public/  (Map, NewsIndex, NewsShow)
    User/    (ReportCreate, MyReports, Notifications)
    Admin/   (Dashboard, Reports, ReportShow, Teams, AssignTeam, Alerts, News, NewsCreate, NewsEdit)
    Responder/ (Dashboard)
  Components/
    Map/IncidentMap.vue, Map/LocationPicker.vue
    Report/MediaUploader.vue
    NotificationBell.vue
  composables/useLiveMap.js
```

## Key Commands
```bash
npm run dev              # Vite dev server
php artisan serve        # Laravel (or use Herd: safenix.test)
php artisan reverb:start # WebSocket server
php artisan queue:work   # Queue worker (emails, notifications)
```

## Database
- 13 custom migrations + Spatie permission tables
- Seeded: 64 districts, 494 upazilas, 10 disaster categories, 3 roles
- Default users: admin@safenix.com / test@example.com (password: "password")

## .env Keys Needed
- `GOOGLE_MAPS_API_KEY` — for maps
- Gmail SMTP: `MAIL_HOST=smtp.gmail.com`, `MAIL_PORT=587`, `MAIL_USERNAME`, `MAIL_PASSWORD` (App Password)
- `BROADCAST_CONNECTION=reverb`
- `QUEUE_CONNECTION=database`

## Build Phases Completed
1. **Foundation** — Laravel + Breeze + Spatie + all migrations/models/seeders + auth with role redirect
2. **Core Build** — Report submission + admin verify/reject + My Reports + role-based nav
3. **Integrations** — Google Maps picker + live map + media upload + Reverb real-time + notifications + alerts + rescue team assignment + email
4. **Finish** — News module (convert report → article) + location filters on map/news + responder panel

## Important Notes
- Spatie middleware must be manually aliased in `bootstrap/app.php` (Laravel 11 style)
- The `role:admin` / `role:responder` middleware is used on route groups
- User roles are shared to frontend via `HandleInertiaRequests` middleware (`auth.roles`)
- Report flow: pending → verified (public) or rejected (user notified)
- Responder sees assignments by matching their email to team member emails
