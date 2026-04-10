<template>
  <div class="welcome-page">

    <!-- Navbar -->
    <nav class="nav">
      <div class="nav-brand">
        <span class="nav-logo">⬡</span>
        <span class="nav-brand-name">CommunityHub</span>
      </div>
      <div class="nav-links">
        <Link href="/login" class="nav-btn ghost">Sign in</Link>
        <Link href="/register" class="nav-btn filled">Get started</Link>
      </div>
    </nav>

    <!-- Hero split -->
    <div class="hero-split">

      <!-- Left -->
      <div class="hero-left">
        <div class="hero-badge">📢 Announcements & Reminders</div>
        <h1 class="hero-title">Stay in the loop<br>with your community</h1>
        <p class="hero-tagline">
          A quiet place for your community to share what matters —
          no noise, just the updates that count.
        </p>
        <div class="hero-actions">
          <Link href="/register" class="cta-btn">Join the community</Link>
          <Link href="/login" class="cta-link">Already a member? Sign in →</Link>
        </div>

        <div class="hero-stats">
          <div class="hero-stat">
            <span class="hero-stat-value">100%</span>
            <span class="hero-stat-label">Free to join</span>
          </div>
          <div class="hero-stat-divider"></div>
          <div class="hero-stat">
            <span class="hero-stat-value">📢</span>
            <span class="hero-stat-label">Announcements</span>
          </div>
          <div class="hero-stat-divider"></div>
          <div class="hero-stat">
            <span class="hero-stat-value">🔔</span>
            <span class="hero-stat-label">Reminders</span>
          </div>
        </div>
      </div>

      <!-- Right: preview panel -->
      <div class="hero-right">
        <div class="preview-panel">
          <div class="preview-header">
            <span class="preview-label">Live feed preview</span>
            <span class="preview-dot"></span>
          </div>

          <article class="post-card pinned">
            <div class="pin-badge">📌 Pinned</div>
            <div class="post-meta-top">
              <span class="type-badge announcement">📢 Announcement</span>
              <span class="post-date">Apr 9, 2026</span>
            </div>
            <h2 class="post-title">Welcome to the community board</h2>
            <p class="post-excerpt">This is your go-to place for important updates, reminders, and announcements from your community admins…</p>
            <div class="post-footer">
              <span class="post-author">By Admin</span>
              <div class="post-stats">
                <span class="stat">💬 4</span>
                <span class="stat">❤️ 12</span>
                <span class="stat">👁 38</span>
              </div>
            </div>
          </article>

          <article class="post-card">
            <div class="post-meta-top">
              <span class="type-badge reminder">🔔 Reminder</span>
              <span class="post-date">Apr 7, 2026</span>
            </div>
            <h2 class="post-title">Monthly dues due this Friday</h2>
            <p class="post-excerpt">Just a friendly reminder that monthly dues are due this Friday. Please settle before end of day…</p>
            <div class="post-footer">
              <span class="post-author">By Admin</span>
              <div class="post-stats">
                <span class="stat">💬 1</span>
                <span class="stat">❤️ 3</span>
                <span class="stat">👁 21</span>
              </div>
            </div>
          </article>
        </div>
      </div>

    </div>

    <!-- replace the existing site-footer -->
<footer class="site-footer">
  <div class="site-footer-inner">
    <div class="site-footer-brand">
      <span class="footer-logo">⬡</span>
      <span class="footer-brand-name">CommunityHub</span>
    </div>
    <div class="site-footer-links">
      <a href="#">Privacy Policy</a>
      <span>·</span>
      <a href="#">Terms of Service</a>
      <span>·</span>
      <a href="#">Help</a>
    </div>
    <p class="site-footer-copy">© 2026 CommunityHub. All rights reserved.</p>
  </div>
</footer>

  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<style scoped>
.welcome-page {
  min-height: 100vh;
  background: var(--bg);
  display: flex;
  flex-direction: column;
}

/* Nav */
.nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1.25rem 3rem;
  background: var(--surface-solid);
  border-bottom: 1px solid var(--border);
}

.nav-brand {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.nav-logo {
  font-size: 1.5rem;
  color: var(--accent);
  line-height: 1;
}

.nav-brand-name {
  font-family: 'DM Serif Display', serif;
  font-size: 1.1rem;
  font-weight: 400;
  color: var(--text);
  letter-spacing: -0.01em;
}

.nav-links { display: flex; gap: 0.6rem; align-items: center; }

.nav-btn {
  padding: 0.45rem 1.1rem;
  border-radius: 8px;
  font-size: 0.875rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.15s;
}

.nav-btn.ghost {
  color: var(--text-muted);
  border: 1px solid var(--border);
  background: none;
}

.nav-btn.ghost:hover { border-color: var(--border-strong); color: var(--text); }

.nav-btn.filled {
  background: var(--accent);
  color: #fff;
  border: 1px solid var(--accent);
}

.nav-btn.filled:hover { opacity: 0.9; }

/* Hero split */
.hero-split {
  flex: 1;
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: calc(100vh - 60px - 48px);
}

/* Left */
.hero-left {
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 4rem 3rem 4rem 4rem;
  background: var(--surface-solid);
  border-right: 1px solid var(--border);
}

.hero-badge {
  display: inline-block;
  font-size: 0.78rem;
  font-weight: 600;
  color: var(--accent);
  background: var(--accent-light);
  padding: 0.3rem 0.85rem;
  border-radius: 20px;
  margin-bottom: 1.5rem;
  letter-spacing: 0.01em;
  width: fit-content;
}

.hero-title {
  font-family: 'DM Serif Display', serif;
  font-size: clamp(2rem, 3.5vw, 3rem);
  font-weight: 400;
  letter-spacing: -0.03em;
  line-height: 1.15;
  color: var(--text);
  margin-bottom: 1.25rem;
}

.hero-tagline {
  font-size: 1rem;
  color: var(--text-muted);
  line-height: 1.7;
  max-width: 420px;
  margin-bottom: 2.5rem;
}

.hero-actions {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 1rem;
  margin-bottom: 3rem;
}

.cta-btn {
  padding: 0.75rem 2rem;
  background: var(--accent);
  color: #fff;
  border-radius: 10px;
  font-size: 0.95rem;
  font-weight: 600;
  text-decoration: none;
  transition: opacity 0.15s;
}

.cta-btn:hover { opacity: 0.9; }

.cta-link {
  font-size: 0.875rem;
  color: var(--text-muted);
  text-decoration: none;
  transition: color 0.15s;
}

.cta-link:hover { color: var(--text); }

.hero-stats {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  padding-top: 2rem;
  border-top: 1px solid var(--border);
}

.hero-stat {
  display: flex;
  flex-direction: column;
  gap: 0.2rem;
}

.hero-stat-value {
  font-size: 1.1rem;
  font-weight: 700;
  color: var(--text);
}

.hero-stat-label {
  font-size: 0.775rem;
  color: var(--text-muted);
}

.hero-stat-divider {
  width: 1px;
  height: 32px;
  background: var(--border);
}

/* Right */
.hero-right {
  background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 40%, #7c3aed 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 3rem 2.5rem;
  position: relative;
  overflow: hidden;
}

.hero-right::before {
  content: '';
  position: absolute;
  width: 500px;
  height: 500px;
  border-radius: 50%;
  background: rgba(255,255,255,0.05);
  top: -150px;
  right: -150px;
}

.hero-right::after {
  content: '';
  position: absolute;
  width: 350px;
  height: 350px;
  border-radius: 50%;
  background: rgba(255,255,255,0.05);
  bottom: -100px;
  left: -80px;
}

.preview-panel {
  position: relative;
  z-index: 1;
  width: 100%;
  max-width: 400px;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.preview-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.5rem;
}

.preview-label {
  font-size: 0.75rem;
  font-weight: 600;
  color: rgba(255,255,255,0.6);
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.preview-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #4ade80;
  box-shadow: 0 0 6px #4ade80;
}

/* Post cards inside preview */
.post-card {
  background: rgba(255,255,255,0.95);
  border: 1px solid rgba(255,255,255,0.2);
  border-radius: var(--radius);
  padding: 1.25rem;
  box-shadow: 0 8px 32px rgba(0,0,0,0.2);
  backdrop-filter: blur(8px);
}

.post-card.pinned {
  background: linear-gradient(to bottom right, #fffbeb, #ffffff);
  border-color: #fbbf24;
}

.pin-badge {
  font-size: 0.72rem;
  font-weight: 600;
  color: #92400e;
  margin-bottom: 0.6rem;
}

.post-meta-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.6rem;
}

.type-badge {
  font-size: 0.72rem;
  font-weight: 600;
  padding: 0.2rem 0.6rem;
  border-radius: 20px;
}

.type-badge.announcement {
  background: var(--announcement-light);
  color: var(--announcement);
}

.type-badge.reminder {
  background: var(--reminder-light);
  color: var(--reminder);
}

.post-date { font-size: 0.75rem; color: var(--text-light); }

.post-title {
  font-family: 'DM Serif Display', serif;
  font-size: 1rem;
  font-weight: 400;
  letter-spacing: -0.01em;
  margin-bottom: 0.4rem;
  color: var(--text);
  line-height: 1.4;
}

.post-excerpt {
  font-size: 0.825rem;
  color: var(--text-muted);
  line-height: 1.6;
  margin-bottom: 1rem;
}

.post-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 0.75rem;
  border-top: 1px solid var(--border);
}

.post-author { font-size: 0.775rem; font-weight: 500; color: var(--text-muted); }
.post-stats { display: flex; gap: 0.75rem; }
.stat { font-size: 0.775rem; color: var(--text-light); }

/* Footer */
/* Footer */
.site-footer {
  background: var(--surface-solid);
  border-top: 1px solid var(--border);
  padding: 1.5rem 3rem;
}

.site-footer-inner {
  max-width: 1100px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 1rem;
}

.site-footer-brand {
  display: flex;
  align-items: center;
  gap: 0.4rem;
}

.footer-logo {
  font-size: 1.2rem;
  color: var(--accent);
}

.footer-brand-name {
  font-family: 'DM Serif Display', serif;
  font-size: 0.95rem;
  font-weight: 400;
  color: var(--text);
}

.site-footer-links {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.site-footer-links a {
  font-size: 0.8rem;
  color: var(--text-muted);
  text-decoration: none;
  transition: color 0.15s;
}

.site-footer-links a:hover { color: var(--text); }

.site-footer-links span {
  color: var(--border-strong);
  font-size: 0.8rem;
}

.site-footer-copy {
  font-size: 0.775rem;
  color: var(--text-light);
}
@media (max-width: 768px) {
  .hero-split { grid-template-columns: 1fr; }
  .hero-right { display: none; }
  .hero-left { padding: 3rem 1.5rem; border-right: none; }
  .nav { padding: 1rem 1.5rem; }
}
</style>
