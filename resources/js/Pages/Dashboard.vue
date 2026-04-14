<template>
  <AppLayout>
    <div class="dashboard-page">

      <!-- Header -->
      <div class="dashboard-header">
        <div class="header-left">
          <p class="header-eyebrow">Overview</p>
          <h1 class="dashboard-title">Dashboard</h1>
        </div>
        <Link href="/posts/create" class="btn-new-post">
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M8 2v12M2 8h12"/>
          </svg>
          New Post
        </Link>
      </div>

      <!-- Stats -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon-wrap members">
            <svg viewBox="0 0 20 20" fill="currentColor">
              <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
            </svg>
          </div>
          <div class="stat-body">
            <span class="stat-value">{{ stats.total_members }}</span>
            <span class="stat-label">Total Members</span>
          </div>
          <div class="stat-trend up">↑ 12%</div>
        </div>

        <div class="stat-card">
          <div class="stat-icon-wrap posts">
            <svg viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
            </svg>
          </div>
          <div class="stat-body">
            <span class="stat-value">{{ stats.total_posts }}</span>
            <span class="stat-label">Published Posts</span>
          </div>
          <div class="stat-trend up">↑ 5%</div>
        </div>

        <div class="stat-card">
          <div class="stat-icon-wrap announcements">
            <svg viewBox="0 0 20 20" fill="currentColor">
              <path d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z"/>
            </svg>
          </div>
          <div class="stat-body">
            <span class="stat-value">{{ stats.total_announcements }}</span>
            <span class="stat-label">Announcements</span>
          </div>
          <div class="stat-trend neutral">— same</div>
        </div>

        <div class="stat-card">
          <div class="stat-icon-wrap reminders">
            <svg viewBox="0 0 20 20" fill="currentColor">
              <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
            </svg>
          </div>
          <div class="stat-body">
            <span class="stat-value">{{ stats.total_reminders }}</span>
            <span class="stat-label">Reminders</span>
          </div>
          <div class="stat-trend up">↑ 3%</div>
        </div>

        <div class="stat-card">
          <div class="stat-icon-wrap comments">
            <svg viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
            </svg>
          </div>
          <div class="stat-body">
            <span class="stat-value">{{ stats.total_comments }}</span>
            <span class="stat-label">Total Comments</span>
          </div>
          <div class="stat-trend up">↑ 8%</div>
        </div>
      </div>

      <!-- Recent Posts -->
      <div class="posts-panel">
        <div class="panel-header">
          <div class="panel-header-left">
            <h2 class="panel-title">Recent Posts</h2>
            <span class="post-count">{{ recentPosts.length }} posts</span>
          </div>
          <Link href="/feed" class="view-all-link">
            View all
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M3 8h10M9 4l4 4-4 4"/>
            </svg>
          </Link>
        </div>

        <!-- Table header -->
        <div class="table-header">
          <span class="col-title">Title</span>
          <span class="col-type">Type</span>
          <span class="col-meta">Comments</span>
          <span class="col-meta">Reactions</span>
          <span class="col-date">Date</span>
          <span class="col-actions">Actions</span>
        </div>

        <!-- Rows -->
        <div
          v-for="post in recentPosts"
          :key="post.id"
          class="table-row"
        >
          <span class="col-title row-title">{{ post.title }}</span>

          <span class="col-type">
            <span class="type-badge" :class="post.type">{{ post.type }}</span>
          </span>

          <span class="col-meta row-meta">
            <svg class="meta-icon" viewBox="0 0 16 16" fill="currentColor">
              <path fill-rule="evenodd" d="M14 2H2a1 1 0 00-1 1v8a1 1 0 001 1h2v2.5l3-2.5H14a1 1 0 001-1V3a1 1 0 00-1-1zM4 7h8v1H4V7zm0-2h8v1H4V5z" clip-rule="evenodd"/>
            </svg>
            {{ post.comments_count }}
          </span>

          <span class="col-meta row-meta">
            <svg class="meta-icon" viewBox="0 0 16 16" fill="currentColor">
              <path fill-rule="evenodd" d="M8 1.5a6.5 6.5 0 100 13 6.5 6.5 0 000-13zM8 4a1 1 0 011 1v2h2a1 1 0 110 2H9v2a1 1 0 11-2 0V9H5a1 1 0 010-2h2V5a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            {{ post.reactions_count }}
          </span>

          <span class="col-date row-date">{{ formatDate(post.published_at) }}</span>

          <!-- Actions -->
          <div class="col-actions row-actions">
            <div class="action-tip-wrap">
              <Link :href="`/posts/${post.id}`" class="action-btn btn-view">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                  <ellipse cx="8" cy="8" rx="7" ry="5"/>
                  <circle cx="8" cy="8" r="2.5" fill="currentColor" stroke="none"/>
                </svg>
              </Link>
              <span class="action-tip">View</span>
            </div>

            <div class="action-tip-wrap">
              <Link :href="`/posts/${post.id}/edit`" class="action-btn btn-edit">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path d="M11.5 2.5l2 2-8.5 8.5H3v-2.5l8.5-8.5z"/>
                  <path d="M9.5 4.5l2 2"/>
                </svg>
              </Link>
              <span class="action-tip">Edit</span>
            </div>

            <span class="action-sep"></span>

            <div class="action-tip-wrap">
              <button class="action-btn btn-delete" @click="deletePost(post.id)">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path d="M2 4h12"/>
                  <path d="M5 4V2.5h6V4"/>
                  <path d="M3.5 4l.9 9h7.2l.9-9"/>
                  <path d="M6.5 7v3.5M9.5 7v3.5"/>
                </svg>
              </button>
              <span class="action-tip danger">Delete</span>
            </div>
          </div>
        </div>

        <!-- Empty state -->
        <div v-if="recentPosts.length === 0" class="empty-state">
          <div class="empty-icon">
            <svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5">
              <rect x="8" y="6" width="24" height="30" rx="3"/>
              <path d="M14 14h12M14 19h12M14 24h8"/>
            </svg>
          </div>
          <p class="empty-title">No posts yet</p>
          <p class="empty-sub">Get started by creating your first post</p>
          <Link href="/posts/create" class="empty-cta">Create a post →</Link>
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
/* ─── Base ─────────────────────────────────────────── */
.dashboard-page {
  max-width: 1080px;
  margin: 0 auto;
  padding: 2rem 0 4rem;
  font-family: 'DM Sans', sans-serif;
}

/* ─── Header ─────────────────────────────────────────── */
.dashboard-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 2.25rem;
}

.header-eyebrow {
  font-size: 0.7rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--text-muted);
  margin-bottom: 0.25rem;
}

.dashboard-title {
  font-family: 'DM Serif Display', serif;
  font-size: 2.25rem;
  font-weight: 400;
  letter-spacing: -0.03em;
  line-height: 1;
  color: var(--text);
}

.btn-new-post {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  padding: 0.55rem 1.15rem;
  background: var(--accent);
  color: #fff;
  text-decoration: none;
  border-radius: var(--radius-sm);
  font-size: 0.875rem;
  font-weight: 600;
  transition: opacity 0.15s, transform 0.15s;
  letter-spacing: -0.01em;
}
.btn-new-post svg { width: 14px; height: 14px; flex-shrink: 0; }
.btn-new-post:hover { opacity: 0.88; transform: translateY(-1px); }

/* ─── Stats ─────────────────────────────────────────── */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 0.875rem;
  margin-bottom: 2.25rem;
}

@media (max-width: 860px) {
  .stats-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 560px) {
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

.stat-card {
  background: var(--surface-solid);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 1.1rem 1.15rem;
  display: flex;
  flex-direction: column;
  gap: 0.6rem;
  position: relative;
  overflow: hidden;
  transition: transform 0.15s, box-shadow 0.15s;
}
.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0,0,0,0.07);
}

.stat-icon-wrap {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.stat-icon-wrap svg { width: 18px; height: 18px; }

.stat-icon-wrap.members      { background: #ecfdf5; color: #059669; }
.stat-icon-wrap.posts        { background: #eff6ff; color: #2563eb; }
.stat-icon-wrap.announcements { background: var(--announcement-light); color: var(--announcement); }
.stat-icon-wrap.reminders    { background: var(--reminder-light);     color: var(--reminder); }
.stat-icon-wrap.comments     { background: #fdf4ff; color: #9333ea; }

.stat-body { display: flex; flex-direction: column; gap: 0.15rem; }

.stat-value {
  font-size: 1.85rem;
  font-weight: 700;
  letter-spacing: -0.04em;
  line-height: 1;
  color: var(--text);
}

.stat-label {
  font-size: 0.72rem;
  color: var(--text-muted);
  font-weight: 500;
  line-height: 1.3;
}

.stat-trend {
  font-size: 0.7rem;
  font-weight: 600;
  padding: 0.15rem 0.45rem;
  border-radius: 20px;
  align-self: flex-start;
}
.stat-trend.up      { background: #ecfdf5; color: #059669; }
.stat-trend.down    { background: #fef2f2; color: #dc2626; }
.stat-trend.neutral { background: var(--bg); color: var(--text-muted); }

/* ─── Posts Panel ─────────────────────────────────────── */
.posts-panel {
  background: var(--surface-solid);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
  box-shadow: var(--shadow);
}

.panel-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1.15rem 1.5rem;
  border-bottom: 1px solid var(--border);
}

.panel-header-left {
  display: flex;
  align-items: center;
  gap: 0.6rem;
}

.panel-title {
  font-size: 0.95rem;
  font-weight: 700;
  letter-spacing: -0.01em;
}

.post-count {
  font-size: 0.72rem;
  font-weight: 600;
  color: var(--text-muted);
  background: var(--bg);
  border: 1px solid var(--border);
  padding: 0.15rem 0.55rem;
  border-radius: 20px;
}

.view-all-link {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  font-size: 0.825rem;
  color: var(--accent);
  text-decoration: none;
  font-weight: 500;
  transition: gap 0.15s;
}
.view-all-link svg { width: 13px; height: 13px; }
.view-all-link:hover { gap: 0.5rem; }

/* ─── Table ─────────────────────────────────────────── */
.table-header,
.table-row {
  display: grid;
  grid-template-columns: 2.2fr 1fr 0.75fr 0.75fr 1.1fr 120px;
  gap: 0.75rem;
  padding: 0 1.5rem;
  align-items: center;
}

.table-header {
  padding-top: 0.6rem;
  padding-bottom: 0.6rem;
  background: var(--bg);
  font-size: 0.68rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.07em;
  color: var(--text-muted);
}

.table-row {
  padding-top: 0.9rem;
  padding-bottom: 0.9rem;
  border-top: 1px solid var(--border);
  transition: background 0.12s;
}
.table-row:hover { background: var(--bg); }

/* Columns */
.col-title   { min-width: 0; }
.col-type    {}
.col-meta    { text-align: center; }
.col-date    {}
.col-actions { display: flex; align-items: center; gap: 3px; }

.row-title {
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--text);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.type-badge {
  display: inline-flex;
  align-items: center;
  font-size: 0.68rem;
  font-weight: 600;
  padding: 0.2rem 0.55rem;
  border-radius: 20px;
  text-transform: capitalize;
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

.row-meta {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.3rem;
  font-size: 0.8rem;
  color: var(--text-muted);
  font-weight: 500;
}
.meta-icon {
  width: 12px;
  height: 12px;
  opacity: 0.5;
  flex-shrink: 0;
}

.row-date {
  font-size: 0.78rem;
  color: var(--text-light);
}

/* ─── Action Buttons ─────────────────────────────────── */
.row-actions {
  display: flex;
  align-items: center;
  gap: 3px;
}

.action-tip-wrap {
  position: relative;
  display: inline-flex;
}

.action-tip-wrap .action-tip {
  position: absolute;
  bottom: calc(100% + 7px);
  left: 50%;
  transform: translateX(-50%);
  background: var(--text);
  color: var(--surface-solid);
  font-size: 0.68rem;
  font-weight: 600;
  padding: 0.25rem 0.55rem;
  border-radius: 5px;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.14s, transform 0.14s;
  transform: translateX(-50%) translateY(3px);
  z-index: 20;
}
.action-tip-wrap .action-tip.danger { background: #dc2626; }

.action-tip-wrap:hover .action-tip {
  opacity: 1;
  transform: translateX(-50%) translateY(0);
}

/* Small arrow on tooltip */
.action-tip-wrap .action-tip::after {
  content: '';
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%);
  border: 4px solid transparent;
  border-top-color: var(--text);
}
.action-tip-wrap .action-tip.danger::after {
  border-top-color: #dc2626;
}

.action-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 30px;
  height: 30px;
  border-radius: 7px;
  border: 1px solid var(--border);
  background: transparent;
  cursor: pointer;
  color: var(--text-muted);
  text-decoration: none;
  transition: background 0.12s, border-color 0.12s, color 0.12s, transform 0.1s;
  flex-shrink: 0;
}
.action-btn svg { width: 13px; height: 13px; flex-shrink: 0; }
.action-btn:active { transform: scale(0.93); }

.btn-view:hover  { background: #f0fdf4; border-color: #6ee7b7; color: #059669; }
.btn-edit:hover  { background: #eff6ff; border-color: #93c5fd; color: #2563eb; }
.btn-delete:hover { background: #fef2f2; border-color: #fca5a5; color: #dc2626; }

.action-sep {
  display: inline-block;
  width: 1px;
  height: 16px;
  background: var(--border);
  margin: 0 2px;
  flex-shrink: 0;
}

/* ─── Empty State ─────────────────────────────────────── */
.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 3.5rem 1.5rem;
  gap: 0.5rem;
}

.empty-icon {
  width: 56px;
  height: 56px;
  color: var(--text-muted);
  opacity: 0.35;
  margin-bottom: 0.25rem;
}
.empty-icon svg { width: 100%; height: 100%; }

.empty-title {
  font-size: 0.95rem;
  font-weight: 600;
  color: var(--text);
}

.empty-sub {
  font-size: 0.825rem;
  color: var(--text-muted);
}

.empty-cta {
  margin-top: 0.75rem;
  padding: 0.5rem 1.25rem;
  background: var(--accent);
  color: #fff;
  text-decoration: none;
  border-radius: var(--radius-sm);
  font-size: 0.875rem;
  font-weight: 600;
  transition: opacity 0.15s;
}
.empty-cta:hover { opacity: 0.88; }

/* ─── Responsive ─────────────────────────────────────── */
@media (max-width: 720px) {
  .table-header,
  .table-row {
    grid-template-columns: 1fr 80px 28px;
    gap: 0.5rem;
  }

  .col-meta:nth-child(3),
  .col-meta:nth-child(4),
  .col-date {
    display: none;
  }

  .table-header .col-meta:nth-child(3),
  .table-header .col-meta:nth-child(4),
  .table-header .col-date {
    display: none;
  }
}
</style>
