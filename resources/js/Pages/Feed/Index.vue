<template>
  <AppLayout>
    <div class="feed-page">

      <!-- Flash message -->
      <div v-if="$page.props.flash?.success" class="flash-success">
        {{ $page.props.flash.success }}
      </div>

      <!-- Header -->
      <div class="feed-header">
        <div>
          <h1 class="feed-title">Community Feed</h1>
          <p class="feed-subtitle">Announcements and reminders from your community</p>
        </div>
        <div class="filter-tabs">
          <button
            v-for="f in filters"
            :key="f.value"
            class="filter-tab"
            :class="{ active: activeFilter === f.value }"
            @click="activeFilter = f.value"
          >
            {{ f.label }}
          </button>
        </div>
      </div>

      <!-- Empty state -->
      <div v-if="filteredPosts.length === 0" class="empty-state">
        <div class="empty-icon">📭</div>
        <p class="empty-title">No posts yet</p>
        <p class="empty-sub">Check back later for updates from your community.</p>
      </div>

      <!-- Posts grid -->
      <div class="posts-list">
        <article
          v-for="post in filteredPosts"
          :key="post.id"
          class="post-card"
          :class="{ pinned: post.pinned }"
          @click="goToPost(post)"
        >
          <!-- Pinned badge -->
          <div v-if="post.pinned" class="pin-badge">📌 Pinned</div>

          <!-- Post type badge -->
          <div class="post-meta-top">
            <span class="type-badge" :class="post.type">
              {{ post.type === 'announcement' ? '📢 Announcement' : '🔔 Reminder' }}
            </span>
            <span class="post-date">{{ formatDate(post.published_at) }}</span>
          </div>

          <!-- Content -->
          <h2 class="post-title">{{ post.title }}</h2>
          <p class="post-excerpt">{{ excerpt(post.body) }}</p>

          <!-- Footer -->
          <div class="post-footer">
            <span class="post-author">By {{ post.author.name }}</span>
            <div class="post-stats">
              <span class="stat">💬 {{ post.comments_count }}</span>
              <span class="stat">❤️ {{ post.reactions_count }}</span>
              <span class="stat">👁 {{ post.views_count }}</span>
            </div>
          </div>
        </article>
      </div>

      <!-- Pagination -->
      <div v-if="posts.last_page > 1" class="pagination">
        <Link
          v-for="link in posts.links"
          :key="link.label"
          :href="link.url || ''"
          class="page-btn"
          :class="{ active: link.active, disabled: !link.url }"
          v-html="link.label"
        />
      </div>

    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  posts: Object,
})

const activeFilter = ref('all')

const filters = [
  { label: 'All', value: 'all' },
  { label: 'Announcements', value: 'announcement' },
  { label: 'Reminders', value: 'reminder' },
]

const filteredPosts = computed(() => {
  if (activeFilter.value === 'all') return props.posts.data
  return props.posts.data.filter(p => p.type === activeFilter.value)
})

function goToPost(post) {
  router.visit(`/posts/${post.id}`)
}

function excerpt(body) {
  return body.length > 160 ? body.slice(0, 160) + '…' : body
}

function formatDate(date) {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'short', day: 'numeric', year: 'numeric'
  })
}
</script>

<style scoped>
.feed-page { max-width: 780px; margin: 0 auto; }

.feed-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 2rem;
}

.feed-title {
  font-family: 'DM Serif Display', serif;
  font-size: 2rem;
  font-weight: 400;
  letter-spacing: -0.02em;
  color: var(--text);
}

.feed-subtitle {
  color: var(--text-muted);
  font-size: 0.9rem;
  margin-top: 0.25rem;
}

.filter-tabs {
  display: flex;
  gap: 0.4rem;
  background: var(--surface-solid);
  border: 1px solid var(--border);
  border-radius: 10px;
  padding: 0.3rem;
}

.filter-tab {
  padding: 0.35rem 0.9rem;
  border-radius: 7px;
  border: none;
  background: none;
  cursor: pointer;
  font-size: 0.85rem;
  font-weight: 500;
  color: var(--text-muted);
  transition: all 0.15s;
}

.filter-tab.active {
  background: var(--accent);
  color: #fff;
}

.posts-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.post-card {
  background: var(--surface-solid);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 1.5rem;
  cursor: pointer;
  transition: all 0.2s;
  box-shadow: var(--shadow);
  position: relative;
}

.post-card:hover {
  border-color: var(--border-strong);
  box-shadow: var(--shadow-lg);
  transform: translateY(-1px);
}

.post-card.pinned {
  border-color: #fbbf24;
  background: linear-gradient(to bottom right, #fffbeb, #ffffff);
}

.pin-badge {
  font-size: 0.75rem;
  font-weight: 600;
  color: #92400e;
  margin-bottom: 0.75rem;
}

.post-meta-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.75rem;
}

.type-badge {
  font-size: 0.75rem;
  font-weight: 600;
  padding: 0.25rem 0.7rem;
  border-radius: 20px;
  letter-spacing: 0.01em;
}

.type-badge.announcement {
  background: var(--announcement-light);
  color: var(--announcement);
}

.type-badge.reminder {
  background: var(--reminder-light);
  color: var(--reminder);
}

.post-date {
  font-size: 0.8rem;
  color: var(--text-light);
}

.post-title {
  font-family: 'DM Serif Display', serif;
  font-size: 1.25rem;
  font-weight: 400;
  letter-spacing: -0.01em;
  margin-bottom: 0.5rem;
  color: var(--text);
  line-height: 1.4;
}

.post-excerpt {
  font-size: 0.9rem;
  color: var(--text-muted);
  line-height: 1.65;
  margin-bottom: 1.25rem;
}

.post-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 1rem;
  border-top: 1px solid var(--border);
}

.post-author {
  font-size: 0.8rem;
  font-weight: 500;
  color: var(--text-muted);
}

.post-stats {
  display: flex;
  gap: 1rem;
}

.stat {
  font-size: 0.8rem;
  color: var(--text-light);
}

.empty-state {
  text-align: center;
  padding: 5rem 2rem;
  background: var(--surface-solid);
  border: 1px solid var(--border);
  border-radius: var(--radius);
}

.empty-icon { font-size: 3rem; margin-bottom: 1rem; }

.empty-title {
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.empty-sub { color: var(--text-muted); font-size: 0.9rem; }

.pagination {
  display: flex;
  justify-content: center;
  gap: 0.4rem;
  margin-top: 2.5rem;
  flex-wrap: wrap;
}

.page-btn {
  padding: 0.4rem 0.8rem;
  border-radius: var(--radius-sm);
  border: 1px solid var(--border);
  background: var(--surface-solid);
  font-size: 0.85rem;
  color: var(--text-muted);
  text-decoration: none;
  transition: all 0.15s;
}

.page-btn.active {
  background: var(--accent);
  color: #fff;
  border-color: var(--accent);
}

.page-btn.disabled {
  opacity: 0.4;
  pointer-events: none;
}
</style>
