Here is a clean and focused **prompt** you can give to a coding agent or developer to build the project **without Voyager**, but with all required **dashboard features** and structure:

---

**Prompt to Developer:**

> Build a full-featured **Laravel-based web application** for **BN Car Transport** — an Indian logistics company specializing in car and bike transportation across all major cities.
>
> ### 🧩 Project Overview:
>
> * **Name**: BN Car Transport
> * **Use Case**: Customer-facing transport service website with a fully manageable admin dashboard.
> * **Platform**: Laravel 10+ (no starter kit, no Voyager)
> * **Hosting**: Shared Hosting (Hostinger-compatible)
>
> ### 🔧 Required Features:
>
> #### ✅ Public Website:
>
> * Responsive design with a **desktop header** and **bottom-app-style mobile menu**
> * Sections:
>
>   * Hero slider (dynamic)
>   * Company Introduction
>   * Services (Car Transport, Bike Transport)
>   * Testimonials
>   * News/Blog
>   * City-wise Transport Coverage
>   * Contact & Get in Touch Section
>   * Footer with logo, quick links, company info
>
> #### 🖥️ Admin Dashboard (No Voyager):
>
> * Custom-built using Laravel Breeze or basic Blade authentication (admin role required)
> * CRUD management for:
>
>   * **Services**
>   * **Testimonials**
>   * **Blogs/News**
>   * **Banners (Hero Slider)**
>   * **City Transport List**
>   * **Company Info** (Logo, contact, email, address – editable)
>   * **Website Menus** (Header and Mobile Nav)
>   * **Quote Requests** (submissions from Get A Quote form)
> * Roles & Users:
>
>   * Admin can create users and assign roles (admin/editor)
>
> #### 📩 Get A Quote:
>
> * Modal form on homepage
> * Fields: Name, Phone, From, To, Service Type, Message (Email optional)
> * Saved to DB and visible in dashboard
>
> ### 📁 Technical Notes:
>
> * All pages use Laravel Blade
> * Dynamic content managed from dashboard
> * Use Laravel Storage for images (with `storage:link`)
> * All frontend assets should be fully responsive and SEO-friendly

---

Let me know if you'd like to include routing structure, migrations, or authentication flows in the prompt.
