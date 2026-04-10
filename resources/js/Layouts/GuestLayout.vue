<template>
  <div class="auth-page">

    <!-- Left: Form -->
    <div class="auth-left">
      <div class="auth-brand">
        <span class="auth-logo">⬡</span>
        <span class="auth-brand-name">CommunityHub</span>
      </div>

      <div class="auth-form-wrap">
        <slot />
      </div>

      <!-- Footer -->
      <footer class="auth-footer">
        <div class="auth-footer-links">
          <a href="#">Privacy Policy</a>
          <span>·</span>
          <a href="#">Terms of Service</a>
          <span>·</span>
          <a href="#">Help</a>
        </div>
        <p class="auth-footer-copy">© 2026 CommunityHub. All rights reserved.</p>
      </footer>
    </div>

    <!-- Right: Decorative panel -->
    <div class="auth-right">
      <div class="auth-right-content">
        <div class="decorative-icon">🏘️</div>
        <h2 class="decorative-title">Stay connected with your community</h2>
        <p class="decorative-sub">Announcements, reminders, and updates — all in one place.</p>
        <div class="decorative-dots">
          <span></span><span></span><span></span>
        </div>
      </div>
      <div class="auth-right-footer">
        © 2026 CommunityHub · <a href="#">Privacy</a> · <a href="#">Terms</a>
      </div>
    </div>

  </div>
</template>

<style>
.auth-form-wrap label {
  display: block;
  font-size: 0.85rem;
  font-weight: 600;
  margin-bottom: 0.4rem;
  color: var(--text);
}

.auth-form-wrap input[type="text"],
.auth-form-wrap input[type="email"],
.auth-form-wrap input[type="password"] {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid var(--border);
  border-radius: var(--radius-sm);
  background: var(--bg);
  font-size: 0.9rem;
  color: var(--text);
  transition: border-color 0.15s, box-shadow 0.15s;
  font-family: inherit;
}

.auth-form-wrap input[type="text"]:focus,
.auth-form-wrap input[type="email"]:focus,
.auth-form-wrap input[type="password"]:focus {
  outline: none;
  border-color: var(--accent);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
}

.auth-form-wrap input[type="checkbox"] {
  accent-color: var(--accent);
  width: 15px;
  height: 15px;
  margin-right: 0.4rem;
  vertical-align: middle;
  flex-shrink: 0;
}

.auth-form-wrap .mt-1 { margin-top: 0 !important; }
.auth-form-wrap .mt-2 { margin-top: 0.25rem !important; }
.auth-form-wrap .mt-4 { margin-top: 1.25rem !important; }

.auth-form-wrap p.text-sm.text-red-600 {
  font-size: 0.8rem;
  color: var(--danger);
  margin-top: 0.25rem;
}

.auth-form-wrap .flex.items-center {
  display: flex !important;
  align-items: center !important;
  gap: 0.4rem;
}

.auth-form-wrap .flex.items-center label {
  font-size: 0.875rem;
  font-weight: 400;
  color: var(--text-muted);
  margin-bottom: 0 !important;
  line-height: 1;
}

.auth-form-wrap form > div:last-child {
  margin-top: 1.5rem;
  padding-top: 1rem;
  border-top: 1px solid var(--border);
  display: flex !important;
  align-items: center !important;
  justify-content: space-between !important;
  gap: 0.75rem;
  flex-wrap: wrap;
}

.auth-form-wrap a {
  color: var(--accent);
  font-size: 0.875rem;
  font-weight: 500;
  text-decoration: none;
}

.auth-form-wrap a:hover { opacity: 0.8; }

.auth-form-wrap button[type="submit"],
.auth-form-wrap .ms-4 {
  padding: 0.75rem 1.5rem;
  background: var(--accent);
  color: #fff;
  border: none;
  border-radius: var(--radius-sm);
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: opacity 0.15s;
  font-family: inherit;
  margin-left: 0 !important;
}

.auth-form-wrap button[type="submit"]:hover,
.auth-form-wrap .ms-4:hover { opacity: 0.88; }

.auth-form-wrap button[type="submit"]:disabled,
.auth-form-wrap .ms-4.opacity-25 { opacity: 0.5; cursor: not-allowed; }

/* Nav row */
.auth-nav-row {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 2rem;
}

.auth-nav-btn {
  flex: 1;
  padding: 0.5rem 1rem;
  border-radius: var(--radius-sm);
  font-size: 0.875rem;
  font-weight: 600;
  text-align: center;
  text-decoration: none;
  transition: all 0.15s;
  border: 1px solid var(--border);
  color: var(--text-muted);
  background: var(--bg);
}

.auth-nav-btn.active {
  background: var(--accent);
  color: #fff;
  border-color: var(--accent);
}

.auth-nav-btn:hover:not(.active) {
  border-color: var(--border-strong);
  color: var(--text);
}

.auth-back-link {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  font-size: 0.8rem;
  color: var(--text-muted);
  text-decoration: none;
  margin-bottom: 1.5rem;
  transition: color 0.15s;
}

.auth-back-link:hover { color: var(--text); }
</style>

<style scoped>
.auth-page {
  min-height: 100vh;
  display: flex;
  background: var(--bg);
}

/* Left */
.auth-left {
  width: 100%;
  max-width: 480px;
  display: flex;
  flex-direction: column;
  padding: 2.5rem 3rem;
  background: var(--surface-solid);
  border-right: 1px solid var(--border);
}

.auth-brand {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.5rem;
}

.auth-logo {
  font-size: 1.6rem;
  color: var(--accent);
  line-height: 1;
}

.auth-brand-name {
  font-family: 'DM Serif Display', serif;
  font-size: 1.1rem;
  font-weight: 400;
  color: var(--text);
  letter-spacing: -0.01em;
}

.auth-form-wrap {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 2rem 0;
}

/* Footer */
.auth-footer {
  margin-top: auto;
  padding-top: 1.5rem;
  border-top: 1px solid var(--border);
}

.auth-footer-links {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.4rem;
  flex-wrap: wrap;
}

.auth-footer-links a {
  font-size: 0.775rem;
  color: var(--text-muted);
  text-decoration: none;
  transition: color 0.15s;
}

.auth-footer-links a:hover { color: var(--text); }

.auth-footer-links span {
  color: var(--border-strong);
  font-size: 0.775rem;
}

.auth-footer-copy {
  font-size: 0.75rem;
  color: var(--text-light);
}

/* Right */
.auth-right {
  flex: 1;
  background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 40%, #7c3aed 100%);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 3rem;
  position: relative;
  overflow: hidden;
}

.auth-right::before {
  content: '';
  position: absolute;
  width: 600px;
  height: 600px;
  border-radius: 50%;
  background: rgba(255,255,255,0.05);
  top: -150px;
  right: -150px;
}

.auth-right::after {
  content: '';
  position: absolute;
  width: 400px;
  height: 400px;
  border-radius: 50%;
  background: rgba(255,255,255,0.05);
  bottom: -100px;
  left: -100px;
}

.auth-right-content {
  position: relative;
  z-index: 1;
  text-align: center;
  color: #fff;
  max-width: 360px;
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.decorative-icon {
  font-size: 4rem;
  margin-bottom: 1.5rem;
  filter: drop-shadow(0 4px 12px rgba(0,0,0,0.2));
}

.decorative-title {
  font-family: 'DM Serif Display', serif;
  font-size: 2rem;
  font-weight: 400;
  line-height: 1.3;
  margin-bottom: 1rem;
  letter-spacing: -0.02em;
}

.decorative-sub {
  font-size: 1rem;
  line-height: 1.7;
  opacity: 0.8;
  margin-bottom: 2.5rem;
}

.decorative-dots {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
}

.decorative-dots span {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: rgba(255,255,255,0.4);
}

.decorative-dots span:first-child {
  background: #fff;
  width: 24px;
  border-radius: 4px;
}

/* Right footer */
.auth-right-footer {
  position: relative;
  z-index: 1;
  font-size: 0.75rem;
  color: rgba(255,255,255,0.45);
  text-align: center;
  margin-top: auto;
}

.auth-right-footer a {
  color: rgba(255,255,255,0.55);
  text-decoration: none;
  transition: color 0.15s;
}

.auth-right-footer a:hover { color: rgba(255,255,255,0.9); }

@media (max-width: 768px) {
  .auth-right { display: none; }
  .auth-left { max-width: 100%; border-right: none; }
}
</style>
