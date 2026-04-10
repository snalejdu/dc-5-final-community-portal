<template>
  <div class="app-shell">
    <nav class="navbar">
      <div class="nav-inner">
        <Link href="/feed" class="brand">
          <span class="brand-icon">⬡</span>
          <span class="brand-name">CommunityHub</span>
        </Link>

        <div class="nav-links">
          <Link href="/feed" class="nav-link" :class="{ active: $page.url.startsWith('/feed') }">
            Feed
          </Link>
          <template v-if="$page.props.auth.user.role === 'admin'">
            <Link href="/dashboard" class="nav-link" :class="{ active: $page.url === '/dashboard' }">
              Dashboard
            </Link>
            <Link href="/posts/create" class="nav-btn">
              + New Post
            </Link>
          </template>
        </div>

        <div class="nav-user">
          <span class="user-name">{{ $page.props.auth.user.name }}</span>
          <span class="user-badge" :class="$page.props.auth.user.role">
            {{ $page.props.auth.user.role }}
          </span>
          <Link href="/logout" method="post" as="button" class="logout-btn">
            Sign out
          </Link>
        </div>
      </div>
    </nav>

    <main class="main-content">
      <slot />
    </main>

    <footer class="app-footer">
      <div class="app-footer-inner">
        <div class="app-footer-brand">
          <span class="footer-logo">⬡</span>
          <span class="footer-brand-name">CommunityHub</span>
        </div>
        <div class="app-footer-links">
          <a href="#">Privacy Policy</a>
          <span>·</span>
          <a href="#">Terms of Service</a>
          <span>·</span>
          <a href="#">Help</a>
        </div>
        <p class="app-footer-copy">© 2026 CommunityHub. All rights reserved.</p>
      </div>
    </footer>

  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<style scoped>
.app-shell {
  min-height: 100vh;
  background: var(--bg);
  font-family: 'DM Sans', sans-serif;
  display: flex;
  flex-direction: column;
}

.navbar {
  position: sticky;
  top: 0;
  z-index: 100;
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  backdrop-filter: blur(12px);
}

.nav-inner {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 2rem;
  height: 60px;
  display: flex;
  align-items: center;
  gap: 2rem;
}

.brand {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
  font-weight: 700;
  font-size: 1.1rem;
  color: var(--text);
  letter-spacing: -0.02em;
}

.brand-icon {
  font-size: 1.4rem;
  color: var(--accent);
}

.nav-links {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-left: auto;
}

.nav-link {
  padding: 0.4rem 0.9rem;
  border-radius: 8px;
  color: var(--text-muted);
  text-decoration: none;
  font-size: 0.9rem;
  font-weight: 500;
  transition: all 0.15s;
}

.nav-link:hover,
.nav-link.active {
  color: var(--text);
  background: var(--hover);
}

.nav-btn {
  padding: 0.4rem 1rem;
  border-radius: 8px;
  background: var(--accent);
  color: #fff;
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 600;
  transition: opacity 0.15s;
}

.nav-btn:hover { opacity: 0.88; }

.nav-user {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  margin-left: 1rem;
  padding-left: 1rem;
  border-left: 1px solid var(--border);
}

.user-name {
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--text);
}

.user-badge {
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  padding: 0.15rem 0.5rem;
  border-radius: 20px;
}

.user-badge.admin {
  background: #fef3c7;
  color: #92400e;
}

.user-badge.member {
  background: #e0f2fe;
  color: #075985;
}

.logout-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 0.8rem;
  color: var(--text-muted);
  padding: 0.3rem 0.6rem;
  border-radius: 6px;
  transition: all 0.15s;
}

.logout-btn:hover {
  color: var(--danger);
  background: #fee2e2;
}

.main-content {
  max-width: 1100px;
  margin: 0 auto;
  padding: 2rem;
  width: 100%;
  flex: 1;
}

/* Footer */
.app-footer {
  background: var(--surface-solid);
  border-top: 1px solid var(--border);
  padding: 1.5rem 2rem;
  margin-top: auto;
}

.app-footer-inner {
  max-width: 1100px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 1rem;
}

.app-footer-brand {
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

.app-footer-links {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.app-footer-links a {
  font-size: 0.8rem;
  color: var(--text-muted);
  text-decoration: none;
  transition: color 0.15s;
}

.app-footer-links a:hover { color: var(--text); }

.app-footer-links span {
  color: var(--border-strong);
  font-size: 0.8rem;
}

.app-footer-copy {
  font-size: 0.775rem;
  color: var(--text-light);
}
</style>
