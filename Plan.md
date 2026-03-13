# 🗓 Capsules Temporelles Numériques — Project Roadmap

**Team:** Mostafa · Karim · Yassir  
**School:** ENSIASDT  
**Duration:** 8 weeks  
**Stack:** HTML · CSS · JavaScript · Bootstrap · Chart.js · Figma

---

## Table of Contents

1. [Project Phases & Tasks](https://claude.ai/chat/a66321de-2426-43d2-a13c-c2f2235cc8e7#1-project-phases--tasks)
2. [Website Pages](https://claude.ai/chat/a66321de-2426-43d2-a13c-c2f2235cc8e7#2-website-pages)
3. [UI/UX Design Tasks (Figma)](https://claude.ai/chat/a66321de-2426-43d2-a13c-c2f2235cc8e7#3-uiux-design-tasks-figma)
4. [Frontend Development Tasks](https://claude.ai/chat/a66321de-2426-43d2-a13c-c2f2235cc8e7#4-frontend-development-tasks)
5. [JavaScript Features](https://claude.ai/chat/a66321de-2426-43d2-a13c-c2f2235cc8e7#5-javascript-features)
6. [Project Folder Structure](https://claude.ai/chat/a66321de-2426-43d2-a13c-c2f2235cc8e7#6-project-folder-structure)
7. [Task Distribution](https://claude.ai/chat/a66321de-2426-43d2-a13c-c2f2235cc8e7#7-task-distribution)
8. [Timeline & Milestones](https://claude.ai/chat/a66321de-2426-43d2-a13c-c2f2235cc8e7#8-timeline--milestones)
9. [Git Workflow](https://claude.ai/chat/a66321de-2426-43d2-a13c-c2f2235cc8e7#9-git-workflow)
10. [Deliverables](https://claude.ai/chat/a66321de-2426-43d2-a13c-c2f2235cc8e7#10-deliverables)

---

## 1. Project Phases & Tasks

### Phase 1 — Planning & Setup (Week 1)

- Read and understand the project brief fully as a team
- Define all website pages needed for the capsule app
- Agree on design direction, color palette, and typography
- Create a shared GitHub repository with branch protection rules
- Set up the folder structure and base HTML templates
- Divide responsibilities clearly among the 3 members

### Phase 2 — UI/UX Design in Figma (Weeks 1–2)

- Create low-fidelity wireframes for all pages
- Define a design system: colors, typography, spacing, icons
- Design UI components: navbar, buttons, cards, forms, modals, tables, badges
- Build high-fidelity mockups for Landing, Auth, Dashboard, and Capsule pages
- Create responsive variants (mobile, tablet, desktop)
- Build a clickable Figma prototype for the main user flow
- Get team review and approval before coding starts

### Phase 3 — Frontend Development HTML/CSS (Weeks 3–5)

- Set up base CSS variables and reset — matching the Figma design system
- Build shared components: navbar, footer, sidebar, modals, alert boxes
- Develop **Landing page**: hero, services, testimonials, stats, contact form, footer
- Develop **Auth pages**: login form, register form with validation UI
- Develop **Dashboard** with Bootstrap grid: sidebar nav, stat cards, chart placeholders
- Develop **Capsule pages**: create, view, members, countdown, gallery
- Develop **Profile & Settings** pages
- Implement responsive layouts using Bootstrap and custom media queries
- Cross-browser and mobile testing for every page

### Phase 4 — JavaScript Functionality (Weeks 4–6)

- Implement form validation on auth and capsule creation forms
- Build password strength indicator with live feedback
- Implement countdown timer logic for locked capsules
- Build capsule lock/unlock mechanism based on date comparison
- Integrate Chart.js for dashboard stats
- Implement photo preview before upload and lightbox gallery
- Build search and filter for the capsule list page
- Add smooth animations and scroll-based transitions on the Landing page
- Implement notification toast system
- Simulate API calls with localStorage for demo data persistence

### Phase 5 — Testing & Debugging (Week 7)

- Test every page on Chrome, Firefox, Safari, and Edge
- Test all breakpoints: 320px, 768px, 1024px, 1440px
- Test all form validations with valid and invalid data
- Check capsule lock/unlock logic with past and future dates
- Fix any layout bugs or JavaScript errors found
- Validate HTML and CSS using W3C validators
- Review page load performance — compress images, clean up CSS

### Phase 6 — Final Polish & Delivery (Week 8)

- Final design consistency review — match every page to the Figma spec
- Add SEO meta tags, Open Graph tags, page titles and descriptions
- Deploy the project to GitHub Pages or Netlify
- Prepare presentation slides: project overview, demo walkthrough, tech choices
- Rehearse the live demo as a team
- Final code cleanup and README documentation

---

## 2. Website Pages

|Page|File|Purpose|
|---|---|---|
|Landing Page|`index.html`|Main entry point. Presents the app concept, features, testimonials, stats, and a contact form.|
|Login|`pages/login.html`|Authentication for returning users. Email and password form with validation and error states.|
|Register|`pages/register.html`|Sign-up page with name, email, password, confirm password, strength meter, and T&C link.|
|Dashboard|`pages/dashboard.html`|Overview with key stats, activity chart, recent capsules list, and sidebar navigation.|
|My Capsules|`pages/capsules.html`|List of all capsules created or joined. Shows lock status, countdown, group, and date.|
|Create Capsule|`pages/create-capsule.html`|Form to create a new capsule: title, open date, group members, add messages and photos.|
|Capsule View|`pages/capsule.html`|Shows a single capsule — locked (countdown displayed) or unlocked (full content revealed).|
|Groups|`pages/groups.html`|Manage friend groups. Create groups, invite members, view shared capsules.|
|Profile|`pages/profile.html`|User profile page with editable name, email, avatar, and personal stats.|
|Settings|`pages/settings.html`|Account settings: password change, notification preferences, privacy policy, logout.|

---

## 3. UI/UX Design Tasks (Figma)

### Wireframes

- Low-fidelity wireframes for all 10 pages
- Mobile and desktop variants for each page
- Navigation flow diagram showing page transitions

### Design System

- **Colors:** Primary brand color, secondary, background, surface, danger, success, warning
- **Typography:** Heading font (display), body font, code font — sizes H1–H4, body, caption, label
- **Spacing:** 4px base grid — spacing scale: 4, 8, 12, 16, 24, 32, 48, 64px
- **Shadows and borders:** Define border radius (sm, md, lg), border weights, shadow levels

### UI Components

- Navbar (desktop + mobile hamburger)
- Sidebar (expanded + collapsed states)
- Buttons (primary, secondary, danger, ghost, icon-only)
- Form inputs (text, email, password, textarea, file upload, date picker)
- Cards (capsule card, stat card, member card)
- Modals (confirmation, form modal, image viewer)
- Badges and tags (status: locked, unlocked, pending)
- Toast notifications (success, error, info)
- Countdown timer display
- Password strength indicator bar
- Pagination and search bar

### High-Fidelity Mockups

- Landing page — all sections
- Login and Register pages
- Dashboard — full layout with charts
- Capsule list and capsule view pages
- Create capsule form
- Groups and profile pages

### Responsive Design

- Breakpoints: 320px (mobile), 768px (tablet), 1024px (laptop), 1440px (desktop)
- Collapsible sidebar for dashboard on mobile
- Stacked cards layout on mobile

### Interactive Prototype

- Clickable flow: Landing → Register → Dashboard → Create Capsule → View Capsule
- Show locked and unlocked states for capsule view

---

## 4. Frontend Development Tasks

### Base Setup

- CSS variables file (`variables.css`) matching Figma design tokens
- Global reset and base styles (`global.css`)
- Bootstrap 5 integration via CDN
- Google Fonts or local fonts integration

### Shared Components

- `navbar.html` — responsive top navigation with links and user avatar
- `sidebar.html` — left sidebar with nav links and active states
- `footer.html` — contact info, social links, legal mentions

### Page Development

**Landing Page**

- Hero section with headline, subtitle, and CTA buttons
- Services/features section with icon cards
- Testimonials section (3 cards)
- Statistics counter section
- Quick contact form
- Footer with social links

**Auth Pages**

- Login form with email, password fields, show/hide toggle, and submit button
- Register form with all fields, password strength bar, T&C checkbox
- Clean centered layout with branding

**Dashboard**

- Bootstrap grid layout with left sidebar
- Stats cards row (total capsules, locked, groups, messages)
- Chart area (capsules over time, locked vs unlocked ratio)
- Recent capsules table

**Capsule Pages**

- Capsule list: grid of cards with status badge and countdown
- Create capsule: multi-field form with file upload area and member input
- Capsule view: locked screen (padlock icon + countdown) and unlocked screen (messages + gallery)

**Other Pages**

- Groups: group cards with member avatars and capsule count
- Profile: avatar, editable fields, activity summary
- Settings: form sections with save buttons

### Responsive Implementation

- Bootstrap grid (`col-12 col-md-6 col-lg-4`) for all card layouts
- Custom media queries for non-Bootstrap components
- Mobile-first approach for all custom CSS

---

## 5. JavaScript Features

### Landing Page (`landing.js`)

- **Sticky navbar:** Changes background color on scroll using `window.addEventListener('scroll', ...)`
- **Mobile hamburger toggle:** Opens/closes mobile nav menu
- **Smooth scrolling:** `scrollIntoView({ behavior: 'smooth' })` for anchor links
- **Scroll animations:** `IntersectionObserver` to trigger fade-in and slide-up on sections
- **Animated counters:** Count up from 0 to target value using `setInterval` when stats section enters viewport
- **Contact form validation:** Check required fields and email format; show success/error message

### Login & Register (`auth.js`)

- **Form validation:** Required fields, email regex check, password length ≥ 8 characters
- **Password strength meter:** Live feedback based on length and character types (weak / medium / strong)
- **Confirm password match:** Real-time error if passwords differ
- **Show/hide password toggle:** Toggle `type="password"` / `type="text"` on button click
- **Simulated auth:** Store user object in `localStorage` on register; check credentials on login; redirect to dashboard

### Dashboard (`dashboard.js`)

- **Dynamic stats:** Read capsule data from `localStorage` and populate stat cards
- **Chart.js bar chart:** Capsules created per month
- **Chart.js doughnut chart:** Locked vs unlocked capsules ratio
- **Sidebar toggle:** Collapse/expand sidebar on mobile with a hamburger button
- **Active link highlight:** Mark current page link as active in sidebar

### My Capsules (`capsules.js`)

- **Filter by status:** Show All / Locked / Unlocked buttons — filter displayed cards on click
- **Live search:** Filter capsule cards by title or group name as the user types in the search input
- **Sort by date:** Sort capsules by opening date (nearest first / furthest first) using `Array.sort()`

### Capsule View (`capsule.js`)

- **Countdown timer:** Calculate remaining time using `Date` comparison; update every second with `setInterval`
    
    ```js
    const diff = targetDate - new Date();const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    ```
    
- **Lock/unlock logic:** If opening date has passed, show full content; otherwise show the locked screen
- **Lightbox gallery:** Click a photo to open full-screen view; arrow buttons to navigate between images

### Create Capsule (`create-capsule.js`)

- **Image preview:** Use `FileReader` API to show thumbnail immediately after file selection
- **Date validation:** Ensure the opening date is at least 1 day in the future
- **Member tag input:** Type a name and press Enter to add a removable tag chip
- **Save to localStorage:** Store the capsule object and redirect with a toast notification

### Shared Utilities (`utils.js`)

- `showToast(message, type)` — display a toast notification (success / error / info)
- `isLoggedIn()` — check if a user is stored in `localStorage`; redirect to login if not
- `formatDate(dateString)` — convert ISO date to a human-readable format
- `getCapsules()` / `saveCapsule(capsule)` — read and write capsule data to `localStorage`

---

## 6. Project Folder Structure

```
capsules-temporelles/
│
├── index.html                  # Landing page
│
├── pages/                      # All inner pages
│   ├── login.html
│   ├── register.html
│   ├── dashboard.html
│   ├── capsules.html
│   ├── create-capsule.html
│   ├── capsule.html
│   ├── groups.html
│   ├── profile.html
│   └── settings.html
│
├── css/                        # Stylesheets
│   ├── variables.css           # Design tokens (colors, spacing, fonts)
│   ├── global.css              # Reset + base styles
│   ├── landing.css
│   ├── auth.css
│   ├── dashboard.css
│   └── capsule.css
│
├── js/                         # JavaScript files
│   ├── utils.js                # Shared helpers (toast, localStorage API)
│   ├── auth.js                 # Login + register logic
│   ├── dashboard.js            # Charts + stats
│   ├── capsule.js              # Countdown timer + lock/unlock logic
│   ├── capsules.js             # Filter + search + sort
│   ├── create-capsule.js       # Form logic + file preview
│   └── landing.js              # Animations + scroll effects
│
├── components/                 # Reusable HTML snippets
│   ├── navbar.html
│   ├── sidebar.html
│   └── footer.html
│
├── assets/                     # Static assets
│   ├── images/
│   ├── icons/
│   └── fonts/
│
├── figma/                      # Exported Figma assets / screenshots
│
└── README.md
```

---

## 7. Task Distribution

### Mostafa — UI/UX Designer + Landing Developer

**Figma Design (Weeks 1–2)**

- All wireframes for all 10 pages
- Full design system (colors, fonts, spacing, components)
- High-fidelity mockups for every page
- Responsive variants and clickable prototype

**Frontend (Weeks 3–5)**

- Landing page HTML/CSS/JS (all sections)
- Scroll animations and counter effects
- SEO meta tags and Open Graph setup
- Final deployment to GitHub Pages or Netlify

**Delivery (Week 8)**

- Presentation slides preparation
- Demo rehearsal lead

---

### Karim — Frontend Developer

**Frontend (Weeks 3–5)**

- Base CSS setup: `variables.css` and `global.css`
- Bootstrap integration and configuration
- Auth pages: Login and Register HTML/CSS
- Dashboard layout with Bootstrap grid
- Capsule list, capsule view, and create capsule pages
- Groups, profile, and settings pages
- Shared components: navbar, sidebar, footer
- Responsive design and cross-browser testing

---

### Yassir — JavaScript & Interaction Developer

**JavaScript (Weeks 4–6)**

- Form validation for all forms (auth + capsule creation)
- Password strength indicator
- Show/hide password toggle
- Capsule countdown timer
- Capsule lock/unlock system
- Chart.js dashboard charts
- Search and filter for capsule list
- Image file preview with FileReader
- Member tag chip input
- Toast notification system
- localStorage data layer (`utils.js`, `storage.js`)

---

### Shared Responsibilities (All team members)

- Code review via pull requests before merging
- Week 7 testing and bug fixing
- Final demo rehearsal together
- README documentation

---

## 8. Timeline & Milestones

|Week|Milestone|Deliverables|
|---|---|---|
|Week 1|Project kickoff|GitHub repo, roles assigned, folder structure|
|Week 1–2|Figma design complete|Wireframes, UI kit, clickable prototype|
|Week 3|Base HTML/CSS done|All pages scaffolded, responsive layout|
|Week 4–5|Frontend complete|Pixel-perfect pages, all components integrated|
|Week 5–6|JavaScript features complete|All JS features working, Chart.js dashboard|
|Week 7|Testing & bug fixes|No critical bugs, valid HTML/CSS|
|Week 8|Delivery & presentation|Site deployed, demo ready, README done|

---

## 9. Git Workflow

### Branch Strategy

|Branch|Purpose|
|---|---|
|`main`|Production branch — only receives merges after review|
|`develop`|Integration branch — all features merge here first|
|`feature/mostafa-landing`|Mostafa's working branch|
|`feature/karim-dashboard`|Karim's working branch|
|`feature/yassir-js`|Yassir's working branch|

**Rule:** Nobody commits directly to `main`. All changes go through a pull request from a feature branch → `develop` → `main`.

### Daily Workflow

```bash
# Start your work session
git checkout develop
git pull origin develop
git checkout feature/yourname-feature

# Make changes, then commit
git add .
git commit -m "feat: add capsule countdown timer"
git push origin feature/yourname-feature

# Open a pull request to develop when the feature is ready
```

### Commit Message Format

```
type: short description (max 60 characters)
```

|Type|Use for|
|---|---|
|`feat`|New feature or page|
|`fix`|Bug fix|
|`style`|CSS or design changes|
|`refactor`|Code restructuring|
|`docs`|README or comments|

### Merging Rules

- Every pull request needs approval from at least 1 other team member
- Merge `develop` → `main` only at major milestones (end of phase)
- Always pull latest `develop` before starting new work to avoid conflicts

---

## 10. Deliverables

### Phase 1 — Planning

- [ ] GitHub repository created with branch rules
- [ ] Folder structure set up
- [ ] Task list and responsibilities agreed upon

### Phase 2 — Design

- [ ] Figma file with all wireframes
- [ ] Figma design system (colors, fonts, components)
- [ ] High-fidelity mockups for all 10 pages
- [ ] Responsive variants
- [ ] Clickable Figma prototype

### Phase 3 & 4 — Development

- [ ] All 10 pages built in HTML and styled with CSS
- [ ] Bootstrap dashboard layout complete
- [ ] All pages responsive on mobile, tablet, and desktop
- [ ] All JavaScript features implemented and working
- [ ] Chart.js charts on dashboard
- [ ] Capsule lock/unlock with countdown timer

### Phase 5 — Testing

- [ ] No critical HTML/CSS/JS bugs
- [ ] W3C HTML and CSS validation passed
- [ ] All pages tested on at least 2 browsers
- [ ] All breakpoints tested

### Phase 6 — Delivery

- [ ] Site deployed and accessible via public URL
- [ ] README with project description, setup instructions, and team names
- [ ] Presentation slides (project overview, demo, tech choices)
- [ ] Final Figma file exported and submitted

---

_Roadmap created for the ENSIASDT Mini Web Project — Capsules Temporelles Numériques_  
_Team: EL HARCHY Mostafa · EL MESKI Karim · AIT BOUHDID Yassir_
