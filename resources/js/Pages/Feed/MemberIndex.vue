<template>
  <MemberLayout>
    <div class="member-feed">

      <div class="welcome-banner">
        <div class="welcome-text">
          <h1 class="welcome-title">Good {{ timeOfDay }}, <em>{{ firstName }}</em> 👋</h1>
          <p class="welcome-sub">Stay up to date with the latest from your community.</p>
        </div>
        <div class="banner-stats">
          <div class="bstat">
            <span class="bstat-val">{{ posts.total }}</span>
            <span class="bstat-label">Posts</span>
          </div>
          <div class="bstat-divider"></div>
          <div class="bstat">
            <span class="bstat-val">{{ posts.data.filter(p => p.type === 'announcement').length }}</span>
            <span class="bstat-label">Announcements</span>
          </div>
          <div class="bstat-divider"></div>
          <div class="bstat">
            <span class="bstat-val">{{ posts.data.filter(p => p.type === 'reminder').length }}</span>
            <span class="bstat-label">Reminders</span>
          </div>
        </div>
      </div>

      <div class="filter-bar">
        <button v-for="f in filters" :key="f.value"
          class="filter-pill" :class="{ active: activeFilter === f.value }"
          @click="activeFilter = f.value">
          {{ f.icon }} {{ f.label }}
        </button>
      </div>

      <div v-if="filteredPosts.length === 0" class="empty-state">
        <div>📭</div>
        <p>No posts yet in this category.</p>
      </div>

      <div class="posts-list">
  <!-- Pinned section: show when there are pinned posts in current filter -->
  <div v-if="pinnedPosts.length">
    <p class="section-label">📌 Pinned</p>
    <article v-for="post in pinnedPosts" :key="post.id"
      class="post-card pinned" @click="router.visit(`/posts/${post.id}`)">
      <PostCardContent :post="post" />
    </article>
  </div>

  <p v-if="unpinnedPosts.length" class="section-label">
    {{ activeFilter === 'all' ? 'Recent' : 'Posts' }}
  </p>

  <article v-for="post in unpinnedPosts" :key="post.id"
    class="post-card" @click="router.visit(`/posts/${post.id}`)">
    <PostCardContent :post="post" />
  </article>
</div>
      <div v-if="posts.last_page > 1" class="pagination">
        <Link v-for="link in posts.links" :key="link.label"
          :href="link.url || '#'" class="page-btn"
          :class="{ active: link.active, disabled: !link.url }"
          v-html="link.label" />
      </div>

    </div>
  </MemberLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PostCardContent from '@/Components/PostCardContent.vue'

const props = defineProps({ posts: Object })
const page = usePage()
const firstName = computed(() => page.props.auth.user.name.split(' ')[0])
const timeOfDay = computed(() => {
  const h = new Date().getHours()
  if (h < 12) return 'morning'
  if (h < 17) return 'afternoon'
  return 'evening'
})
const activeFilter = ref('all')
const filters = [
  { label: 'All Posts', value: 'all', icon: '📋' },
  { label: 'Announcements', value: 'announcement', icon: '📢' },
  { label: 'Reminders', value: 'reminder', icon: '🔔' },
]
const filteredPosts = computed(() => {
  if (activeFilter.value === 'all') return props.posts.data
  return props.posts.data.filter(p => p.type === activeFilter.value)
})
const pinnedPosts = computed(() => filteredPosts.value.filter(p => p.pinned))
const unpinnedPosts = computed(() => filteredPosts.value.filter(p => !p.pinned))
</script>

<style scoped>
.member-feed { max-width: 780px; margin: 0 auto; }
.welcome-banner { background: #1c1917; border-radius: 18px; padding: 2rem 2.5rem; display: flex; align-items: center; justify-content: space-between; gap: 2rem; margin-bottom: 2rem; flex-wrap: wrap; }
.welcome-title { font-size: 1.75rem; font-weight: 300; color: #fff; margin-bottom: 0.35rem; }
.welcome-title em { font-style: italic; color: #f59e0b; }
.welcome-sub { font-size: 0.875rem; color: rgba(255,255,255,0.5); }
.banner-stats { display: flex; align-items: center; gap: 1.5rem; flex-shrink: 0; }
.bstat { text-align: center; }
.bstat-val { display: block; font-size: 1.5rem; font-weight: 700; color: #f59e0b; line-height: 1.1; }
.bstat-label { display: block; font-size: 0.7rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.06em; margin-top: 0.2rem; }
.bstat-divider { width: 1px; height: 32px; background: rgba(255,255,255,0.12); }
.filter-bar { display: flex; gap: 0.5rem; margin-bottom: 1.75rem; flex-wrap: wrap; }
.filter-pill { display: flex; align-items: center; gap: 0.4rem; padding: 0.45rem 1rem; border-radius: 20px; border: 1px solid #e5e3de; background: #fff; font-size: 0.85rem; font-weight: 500; color: #6b6860; cursor: pointer; transition: all 0.15s; }
.filter-pill:hover { border-color: #c5c3be; color: #1c1917; }
.filter-pill.active { background: #1c1917; color: #fff; border-color: #1c1917; }
.section-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #9c9890; margin-bottom: 0.75rem; margin-top: 1.5rem; }
.posts-list { display: flex; flex-direction: column; gap: 0.875rem; }
.post-card { background: #fff; border: 1px solid #e8e5e0; border-radius: 14px; padding: 1.5rem; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
.post-card:hover { border-color: #c5c3be; box-shadow: 0 4px 20px rgba(0,0,0,0.07); transform: translateY(-1px); }
.post-card.pinned { border-color: #fbbf24; background: linear-gradient(135deg, #fffbeb 0%, #fff 60%); }
.empty-state { text-align: center; padding: 4rem 2rem; color: #9c9890; font-size: 1rem; }
.pagination { display: flex; justify-content: center; gap: 0.4rem; margin-top: 2.5rem; flex-wrap: wrap; }
.page-btn { padding: 0.4rem 0.8rem; border-radius: 8px; border: 1px solid #e8e5e0; background: #fff; font-size: 0.85rem; color: #6b6860; text-decoration: none; transition: all 0.15s; }
.page-btn.active { background: #1c1917; color: #fff; border-color: #1c1917; }
.page-btn.disabled { opacity: 0.35; pointer-events: none; }
</style>
