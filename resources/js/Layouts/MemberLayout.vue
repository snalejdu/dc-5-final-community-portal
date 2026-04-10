    <template>
  <div class="member-shell">
    <nav class="member-nav">
      <div class="nav-inner">
        <Link href="/feed" class="brand">
          <span class="brand-hex">⬡</span>
          <span class="brand-text">CommunityHub</span>
        </Link>
        <div class="nav-center">
          <Link href="/feed" class="nav-link"
            :class="{ active: $page.url.startsWith('/feed') || $page.url.startsWith('/posts') }">
            🏠 Feed
          </Link>
          <Link href="/member/profile" class="nav-link"
            :class="{ active: $page.url.startsWith('/member') }">
            👤 My Profile
          </Link>
        </div>
        <div class="nav-right">
          <div class="user-chip">
            <div class="user-avatar">{{ initials }}</div>
            <div class="user-info">
              <span class="user-name">{{ user.name }}</span>
              <span class="user-role">Member</span>
            </div>
          </div>
          <Link href="/logout" method="post" as="button" class="signout-btn">
            Sign out
          </Link>
        </div>
      </div>
    </nav>
    <div class="member-body">
      <slot />
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)
const initials = computed(() =>
  user.value.name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
)
</script>

<style scoped>
.member-shell { min-height: 100vh; background: #f7f5f0; font-family: 'DM Sans', sans-serif; }
.member-nav { background: #1c1917; position: sticky; top: 0; z-index: 100; }
.nav-inner { max-width: 1100px; margin: 0 auto; padding: 0 2rem; height: 58px; display: flex; align-items: center; gap: 2rem; }
.brand { display: flex; align-items: center; gap: 0.5rem; text-decoration: none; color: #fff; font-weight: 700; font-size: 1rem; flex-shrink: 0; }
.brand-hex { color: #f59e0b; font-size: 1.3rem; }
.nav-center { display: flex; align-items: center; gap: 0.25rem; margin: 0 auto; }
.nav-link { display: flex; align-items: center; gap: 0.4rem; padding: 0.4rem 1rem; border-radius: 8px; text-decoration: none; font-size: 0.875rem; font-weight: 500; color: rgba(255,255,255,0.6); transition: all 0.15s; }
.nav-link:hover, .nav-link.active { color: #fff; background: rgba(255,255,255,0.12); }
.nav-right { display: flex; align-items: center; gap: 0.75rem; margin-left: auto; }
.user-chip { display: flex; align-items: center; gap: 0.6rem; }
.user-avatar { width: 32px; height: 32px; border-radius: 50%; background: #f59e0b; color: #1c1917; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; justify-content: center; }
.user-info { display: flex; flex-direction: column; }
.user-name { font-size: 0.8rem; font-weight: 600; color: #fff; line-height: 1.2; }
.user-role { font-size: 0.68rem; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 0.06em; }
.signout-btn { background: none; border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.5); font-size: 0.775rem; padding: 0.3rem 0.75rem; border-radius: 6px; cursor: pointer; transition: all 0.15s; }
.signout-btn:hover { border-color: rgba(255,255,255,0.35); color: #fff; }
.member-body { max-width: 1100px; margin: 0 auto; padding: 2.5rem 2rem; }
</style>
