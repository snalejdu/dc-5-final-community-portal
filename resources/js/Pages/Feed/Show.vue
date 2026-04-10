<template>
  <AppLayout>
    <div class="post-page">

      <!-- Back -->
      <Link href="/feed" class="back-link">← Back to Feed</Link>

      <!-- Flash -->
      <div v-if="$page.props.flash?.success" class="flash-success">
        {{ $page.props.flash.success }}
      </div>

      <!-- Post -->
      <article class="post-full">
        <div class="post-header">
          <div class="post-header-top">
            <span class="type-badge" :class="post.type">
              {{ post.type === 'announcement' ? '📢 Announcement' : '🔔 Reminder' }}
            </span>
            <span v-if="post.pinned" class="pin-badge">📌 Pinned</span>

            <!-- Admin actions -->
            <div v-if="isAdmin" class="admin-actions">
              <Link :href="`/posts/${post.id}/edit`" class="btn-edit">Edit</Link>
              <button class="btn-delete" @click="confirmDelete">Delete</button>
            </div>
          </div>

          <h1 class="post-title">{{ post.title }}</h1>

          <div class="post-byline">
            <span class="author-avatar">{{ post.author.name.charAt(0) }}</span>
            <div>
              <span class="author-name">{{ post.author.name }}</span>
              <span class="post-date">{{ formatDate(post.published_at) }}</span>
            </div>
            <div class="post-stats">
              <span>👁 {{ post.views_count }}</span>
              <span>💬 {{ post.comments_count }}</span>
            </div>
          </div>
        </div>

        <!-- Body -->
        <div class="post-body" v-html="formattedBody"></div>

        <!-- Reactions -->
        <div class="reactions-section">
          <p class="reactions-label">React to this post</p>
          <div class="reaction-buttons">
            <button
              v-for="r in reactionTypes"
              :key="r.type"
              class="reaction-btn"
              :class="{ active: userReaction === r.type }"
              @click="react(r.type)"
            >
              <span class="reaction-emoji">{{ r.emoji }}</span>
              <span class="reaction-count">{{ reactionSummary[r.type] || 0 }}</span>
            </button>
          </div>
        </div>
      </article>

      <!-- Comments -->
      <section class="comments-section">
        <h2 class="comments-title">
          Comments
          <span class="comments-count">{{ post.comments.length }}</span>
        </h2>

        <!-- Comment form -->
        <form class="comment-form" @submit.prevent="submitComment">
          <textarea
            v-model="commentBody"
            class="comment-input"
            placeholder="Share your thoughts..."
            rows="3"
          />
          <div class="comment-form-footer">
            <span v-if="errors.body" class="field-error">{{ errors.body }}</span>
            <button type="submit" class="btn-primary" :disabled="submitting">
              {{ submitting ? 'Posting...' : 'Post Comment' }}
            </button>
          </div>
        </form>

        <!-- Comments list -->
        <div v-if="post.comments.length === 0" class="no-comments">
          No comments yet. Be the first to share your thoughts!
        </div>

        <div class="comments-list">
          <div
            v-for="comment in post.comments"
            :key="comment.id"
            class="comment-card"
          >
            <div class="comment-header">
              <span class="comment-avatar">{{ comment.author.name.charAt(0) }}</span>
              <div class="comment-meta">
                <span class="comment-author">{{ comment.author.name }}</span>
                <span class="comment-date">{{ formatDate(comment.created_at) }}</span>
              </div>
              <button
                v-if="isAdmin || comment.author.id === $page.props.auth.user.id"
                class="comment-delete"
                @click="deleteComment(comment.id)"
              >
                ✕
              </button>
            </div>
            <p class="comment-body">{{ comment.body }}</p>
          </div>
        </div>
      </section>

    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  post: Object,
  reactionSummary: Object,
  userReaction: String,
})

const page = usePage()
const isAdmin = computed(() => page.props.auth.user?.role === 'admin')

const reactionTypes = [
  { type: 'like',  emoji: '👍' },
  { type: 'love',  emoji: '❤️' },
  { type: 'haha',  emoji: '😂' },
  { type: 'sad',   emoji: '😢' },
  { type: 'angry', emoji: '😠' },
]

const commentBody = ref('')
const submitting = ref('')
const errors = ref({})

const formattedBody = computed(() =>
  props.post.body.replace(/\n/g, '<br>')
)

function react(type) {
  router.post(`/posts/${props.post.id}/reactions`, { type }, {
    preserveScroll: true,
  })
}

function submitComment() {
  if (!commentBody.value.trim()) {
    errors.value.body = 'Comment cannot be empty.'
    return
  }
  errors.value = {}
  submitting.value = true

  router.post(`/posts/${props.post.id}/comments`, { body: commentBody.value }, {
    preserveScroll: true,
    onSuccess: () => { commentBody.value = '' },
    onFinish: () => { submitting.value = false },
  })
}

function deleteComment(id) {
  if (!confirm('Delete this comment?')) return
  router.delete(`/comments/${id}`, { preserveScroll: true })
}

function confirmDelete() {
  if (!confirm('Are you sure you want to delete this post?')) return
  router.delete(`/posts/${props.post.id}`)
}

function formatDate(date) {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'short', day: 'numeric', year: 'numeric',
    hour: '2-digit', minute: '2-digit'
  })
}
</script>

<style scoped>
.post-page { max-width: 760px; margin: 0 auto; }

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  text-decoration: none;
  color: var(--text-muted);
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 1.5rem;
  transition: color 0.15s;
}

.back-link:hover { color: var(--text); }

.post-full {
  background: var(--surface-solid);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 2.5rem;
  box-shadow: var(--shadow);
  margin-bottom: 2rem;
}

.post-header-top {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 1.25rem;
  flex-wrap: wrap;
}

.type-badge {
  font-size: 0.75rem;
  font-weight: 600;
  padding: 0.3rem 0.8rem;
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

.pin-badge {
  font-size: 0.75rem;
  font-weight: 600;
  color: #92400e;
}

.admin-actions {
  margin-left: auto;
  display: flex;
  gap: 0.5rem;
}

.btn-edit {
  padding: 0.35rem 0.9rem;
  border-radius: var(--radius-sm);
  background: var(--accent-light);
  color: var(--accent);
  font-size: 0.85rem;
  font-weight: 600;
  text-decoration: none;
  transition: opacity 0.15s;
}

.btn-edit:hover { opacity: 0.8; }

.btn-delete {
  padding: 0.35rem 0.9rem;
  border-radius: var(--radius-sm);
  background: var(--danger-light);
  color: var(--danger);
  font-size: 0.85rem;
  font-weight: 600;
  border: none;
  cursor: pointer;
  transition: opacity 0.15s;
}

.btn-delete:hover { opacity: 0.8; }

.post-title {
  font-family: 'DM Serif Display', serif;
  font-size: 2rem;
  font-weight: 400;
  letter-spacing: -0.02em;
  line-height: 1.3;
  margin-bottom: 1.25rem;
}

.post-byline {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding-bottom: 1.5rem;
  border-bottom: 1px solid var(--border);
  margin-bottom: 1.75rem;
}

.author-avatar, .comment-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: var(--accent);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.875rem;
  font-weight: 700;
  flex-shrink: 0;
  text-transform: uppercase;
}

.comment-avatar {
  width: 32px;
  height: 32px;
  font-size: 0.8rem;
  background: var(--announcement);
}

.author-name {
  display: block;
  font-size: 0.875rem;
  font-weight: 600;
  color: var(--text);
}

.post-date, .comment-date {
  display: block;
  font-size: 0.775rem;
  color: var(--text-light);
}

.post-stats {
  margin-left: auto;
  display: flex;
  gap: 1rem;
  font-size: 0.8rem;
  color: var(--text-light);
}

.post-body {
  font-size: 1rem;
  line-height: 1.8;
  color: var(--text);
  margin-bottom: 2rem;
}

/* Reactions */
.reactions-section {
  padding-top: 1.5rem;
  border-top: 1px solid var(--border);
}

.reactions-label {
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  color: var(--text-muted);
  margin-bottom: 0.75rem;
}

.reaction-buttons {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.reaction-btn {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.45rem 0.9rem;
  border-radius: 20px;
  border: 1px solid var(--border);
  background: var(--bg);
  cursor: pointer;
  font-size: 0.875rem;
  font-weight: 500;
  transition: all 0.15s;
}

.reaction-btn:hover {
  border-color: var(--border-strong);
  transform: scale(1.05);
}

.reaction-btn.active {
  background: var(--accent-light);
  border-color: var(--accent);
  color: var(--accent);
}

.reaction-emoji { font-size: 1.1rem; }
.reaction-count { color: var(--text-muted); }

/* Comments */
.comments-section {
  background: var(--surface-solid);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 2rem;
  box-shadow: var(--shadow);
}

.comments-title {
  font-size: 1.1rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.comments-count {
  background: var(--bg);
  border: 1px solid var(--border);
  border-radius: 20px;
  padding: 0.1rem 0.6rem;
  font-size: 0.8rem;
  color: var(--text-muted);
}

.comment-form {
  margin-bottom: 2rem;
}

.comment-input {
  width: 100%;
  padding: 0.875rem 1rem;
  border: 1px solid var(--border);
  border-radius: var(--radius-sm);
  background: var(--bg);
  font-size: 0.9rem;
  resize: vertical;
  transition: border-color 0.15s;
  color: var(--text);
}

.comment-input:focus {
  outline: none;
  border-color: var(--accent);
}

.comment-form-footer {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  margin-top: 0.75rem;
  gap: 1rem;
}

.field-error {
  font-size: 0.8rem;
  color: var(--danger);
}

.btn-primary {
  padding: 0.55rem 1.25rem;
  background: var(--accent);
  color: #fff;
  border: none;
  border-radius: var(--radius-sm);
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: opacity 0.15s;
}

.btn-primary:hover { opacity: 0.88; }
.btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }

.no-comments {
  text-align: center;
  padding: 2rem;
  color: var(--text-muted);
  font-size: 0.9rem;
}

.comments-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.comment-card {
  padding: 1rem 1.25rem;
  background: var(--bg);
  border-radius: var(--radius-sm);
  border: 1px solid var(--border);
}

.comment-header {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  margin-bottom: 0.6rem;
}

.comment-meta { flex: 1; }
.comment-author {
  display: block;
  font-size: 0.85rem;
  font-weight: 600;
}

.comment-delete {
  background: none;
  border: none;
  cursor: pointer;
  color: var(--text-light);
  font-size: 0.75rem;
  padding: 0.2rem 0.4rem;
  border-radius: 4px;
  transition: all 0.15s;
}

.comment-delete:hover {
  background: var(--danger-light);
  color: var(--danger);
}

.comment-body {
  font-size: 0.9rem;
  color: var(--text);
  line-height: 1.65;
}
</style>
