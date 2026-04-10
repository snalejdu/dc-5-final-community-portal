<template>
  <AppLayout>
    <div class="dashboard-page">

      <div class="dashboard-header">
        <h1 class="dashboard-title">Dashboard</h1>
        <Link href="/posts/create" class="btn-new-post">+ New Post</Link>
      </div>

      <!-- Stats -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon members">👥</div>
          <div class="stat-info">
            <span class="stat-value">{{ stats.total_members }}</span>
            <span class="stat-label">Total Members</span>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon posts">📄</div>
          <div class="stat-info">
            <span class="stat-value">{{ stats.total_posts }}</span>
            <span class="stat-label">Published Posts</span>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon announcements">📢</div>
          <div class="stat-info">
            <span class="stat-value">{{ stats.total_announcements }}</span>
            <span class="stat-label">Announcements</span>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon reminders">🔔</div>
          <div class="stat-info">
            <span class="stat-value">{{ stats.total_reminders }}</span>
            <span class="stat-label">Reminders</span>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon comments">💬</div>
          <div class="stat-info">
            <span class="stat-value">{{ stats.total_comments }}</span>
            <span class="stat-label">Total Comments</span>
          </div>
        </div>
      </div>

      <!-- Recent Posts -->
      <div class="recent-section">
        <div class="section-header">
          <h2 class="section-title">Recent Posts</h2>
          <Link href="/feed" class="view-all">View all →</Link>
        </div>

        <div class="recent-table">
          <div class="table-head">
            <span>Title</span>
            <span>Type</span>
            <span>Comments</span>
            <span>Reactions</span>
            <span>Date</span>
            <span>Actions</span>
          </div>

          <div
            v-for="post in recentPosts"
            :key="post.id"
            class="table-row"
          >
            <span class="row-title">{{ post.title }}</span>
            <span>
              <span class="type-badge" :class="post.type">
                {{ post.type }}
              </span>
            </span>
            <span class="row-stat">💬 {{ post.comments_count }}</span>
            <span class="row-stat">❤️ {{ post.reactions_count }}</span>
            <span class="row-date">{{ formatDate(post.published_at) }}</span>
            <div class="row-actions">
              <Link :href="`/posts/${post.id}`" class="action-view">View</Link>
              <Link :href="`/posts/${post.id}/edit`" class="action-edit">Edit</Link>
              <button class="action-delete" @click="deletePost(post.id)">Delete</button>
            </div>
          </div>

          <div v-if="recentPosts.length === 0" class="table-empty">
            No posts yet. <Link href="/posts/create">Create your first post →</Link>
          </div>
        </div>
      </div>

    </div>
  </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
  stats: Object,
  recentPosts: Array,
})

function deletePost(id) {
  if (!confirm('Delete this post? This cannot be undone.')) return
  router.delete(`/posts/${id}`)
}

function formatDate(date) {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'short', day: 'numeric', year: 'numeric'
  })
}
</script>

<style scoped>
.dashboard-page { max-width: 1000px; margin: 0 auto; }

.dashboard-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 2rem;
}

.dashboard-title {
  font-family: 'DM Serif Display', serif;
  font-size: 2rem;
  font-weight: 400;
  letter-spacing: -0.02em;
}

.btn-new-post {
  padding: 0.55rem 1.25rem;
  background: var(--accent);
  color: #fff;
  text-decoration: none;
  border-radius: var(--radius-sm);
  font-size: 0.9rem;
  font-weight: 600;
  transition: opacity 0.15s;
}

.btn-new-post:hover { opacity: 0.88; }

/* Stats */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 1rem;
  margin-bottom: 2.5rem;
}

.stat-card {
  background: var(--surface-solid);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 1.25rem 1.5rem;
  display: flex;
  align-items: center;
  gap: 1rem;
  box-shadow: var(--shadow);
  transition: transform 0.15s;
}

.stat-card:hover { transform: translateY(-2px); }

.stat-icon {
  font-size: 1.75rem;
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
  flex-shrink: 0;
}

.stat-icon.members    { background: #f0fdf4; }
.stat-icon.posts      { background: #eff6ff; }
.stat-icon.announcements { background: var(--announcement-light); }
.stat-icon.reminders  { background: var(--reminder-light); }
.stat-icon.comments   { background: #fdf4ff; }

.stat-value {
  display: block;
  font-size: 1.75rem;
  font-weight: 700;
  letter-spacing: -0.02em;
  line-height: 1.1;
}

.stat-label {
  display: block;
  font-size: 0.775rem;
  color: var(--text-muted);
  font-weight: 500;
  margin-top: 0.2rem;
}

/* Recent table */
.recent-section {
  background: var(--surface-solid);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
  box-shadow: var(--shadow);
}

.section-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid var(--border);
}

.section-title {
  font-size: 1rem;
  font-weight: 700;
}

.view-all {
  font-size: 0.85rem;
  color: var(--accent);
  text-decoration: none;
  font-weight: 500;
}

.table-head {
  display: grid;
  grid-template-columns: 2fr 1fr 0.7fr 0.7fr 1fr 1.2fr;
  padding: 0.6rem 1.5rem;
  background: var(--bg);
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: var(--text-muted);
  gap: 1rem;
}

.table-row {
  display: grid;
  grid-template-columns: 2fr 1fr 0.7fr 0.7fr 1fr 1.2fr;
  padding: 0.875rem 1.5rem;
  border-top: 1px solid var(--border);
  align-items: center;
  gap: 1rem;
  transition: background 0.15s;
}

.table-row:hover { background: var(--bg); }

.row-title {
  font-size: 0.875rem;
  font-weight: 500;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.type-badge {
  font-size: 0.7rem;
  font-weight: 600;
  padding: 0.2rem 0.6rem;
  border-radius: 20px;
  text-transform: capitalize;
}

.type-badge.announcement {
  background: var(--announcement-light);
  color: var(--announcement);
}

.type-badge.reminder {
  background: var(--reminder-light);
  color: var(--reminder);
}

.row-stat {
  font-size: 0.85rem;
  color: var(--text-muted);
}

.row-date {
  font-size: 0.8rem;
  color: var(--text-light);
}

.row-actions {
  display: flex;
  gap: 0.4rem;
  flex-wrap: wrap;
}

.action-view, .action-edit, .action-delete {
  padding: 0.25rem 0.6rem;
  border-radius: 6px;
  font-size: 0.775rem;
  font-weight: 600;
  text-decoration: none;
  border: none;
  cursor: pointer;
  transition: opacity 0.15s;
}

.action-view  { background: var(--bg); color: var(--text-muted); border: 1px solid var(--border); }
.action-edit  { background: var(--accent-light); color: var(--accent); }
.action-delete { background: var(--danger-light); color: var(--danger); }

.action-view:hover, .action-edit:hover, .action-delete:hover { opacity: 0.75; }

.table-empty {
  padding: 2rem 1.5rem;
  text-align: center;
  color: var(--text-muted);
  font-size: 0.9rem;
}

.table-empty a {
  color: var(--accent);
  text-decoration: none;
  font-weight: 500;
}
</style>
