<template>
  <MemberLayout>
    <div class="post-view">
      <Link href="/feed" class="back-link">← Back to Feed</Link>

      <div v-if="$page.props.flash?.success" class="flash-success">
        ✅ {{ $page.props.flash.success }}
      </div>

      <article class="post-article">
        <div class="post-head">
          <div class="head-top">
            <span class="type-badge" :class="post.type">
              {{ post.type === 'announcement' ? '📢 Announcement' : '🔔 Reminder' }}
            </span>
            <span v-if="post.pinned" class="pin-tag">📌 Pinned</span>
          </div>
          <h1 class="post-title">{{ post.title }}</h1>
          <div class="post-byline">
            <div class="byline-author">
              <div class="author-avatar">{{ post.author.name.charAt(0).toUpperCase() }}</div>
              <div>
                <span class="author-name">{{ post.author.name }}</span>
                <span class="author-label">Community Admin</span>
              </div>
            </div>
            <div class="byline-meta">
              <span>📅 {{ formatDate(post.published_at) }}</span>
              <span>·</span>
              <span>👁 {{ post.views_count }} views</span>
              <span>·</span>
              <span>💬 {{ post.comments_count }} comments</span>
            </div>
          </div>
        </div>

        <div class="post-body" v-html="formattedBody"></div>

        <div class="reaction-bar">
          <p class="reaction-prompt">How do you feel about this post?</p>
          <div class="reactions">
            <button v-for="r in reactionTypes" :key="r.type"
              class="react-btn" :class="{ chosen: currentReaction === r.type }"
              @click="toggleReaction(r.type)">
              <span>{{ r.emoji }}</span>
              <span>{{ localSummary[r.type] || 0 }}</span>
            </button>
          </div>
          <p v-if="currentReaction" class="reaction-feedback">
            You reacted with {{ reactionTypes.find(r => r.type === currentReaction)?.emoji }} —
            <button class="remove-reaction" @click="toggleReaction(currentReaction)">remove</button>
          </p>
        </div>
      </article>

      <section class="comments-wrap">
        <div class="comments-head">
          <h2 class="comments-title">Discussion</h2>
          <span class="comment-count-badge">{{ post.comments.length }}</span>
        </div>

        <div class="write-comment">
          <div class="commenter-avatar">{{ userInitials }}</div>
          <div class="comment-composer">
            <textarea v-model="commentBody" class="composer-input"
              :class="{ 'has-error': commentError }"
              placeholder="Share your thoughts on this post..."
              rows="2" @input="commentError = ''" />
            <p v-if="commentError" class="composer-error">{{ commentError }}</p>
            <div class="composer-actions">
              <span class="char-hint" :class="{ warn: commentBody.length > 900 }">
                {{ commentBody.length }}/1000
              </span>
              <button class="btn-post-comment"
                :disabled="submitting || !commentBody.trim()"
                @click="submitComment">
                {{ submitting ? 'Posting...' : 'Post Comment' }}
              </button>
            </div>
          </div>
        </div>

        <div v-if="post.comments.length === 0" class="no-comments">
          💬 No comments yet. Be the first!
        </div>

        <div class="comments-list">
          <div v-for="comment in post.comments" :key="comment.id" class="comment-item">
            <div class="cmt-avatar">{{ comment.author.name.charAt(0).toUpperCase() }}</div>
            <div class="comment-content">
              <div class="cmt-header">
                <span class="cmt-name">{{ comment.author.name }}</span>
                <span v-if="comment.author.id === $page.props.auth.user.id" class="cmt-you">You</span>
                <span class="cmt-date">{{ timeAgo(comment.created_at) }}</span>
                <button v-if="comment.author.id === $page.props.auth.user.id"
                  class="cmt-delete" @click="deleteComment(comment.id)">🗑</button>
              </div>
              <p class="cmt-body">{{ comment.body }}</p>
            </div>
          </div>
        </div>
      </section>
    </div>
  </MemberLayout>
</template>

<script setup>
import { ref, computed, reactive } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'

const props = defineProps({ post: Object, reactionSummary: Object, userReaction: String })
const page = usePage()
const userInitials = computed(() =>
  page.props.auth.user.name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
)
const currentReaction = ref(props.userReaction || null)
const localSummary = reactive({ ...props.reactionSummary })
const reactionTypes = [
  { type: 'like', emoji: '👍' }, { type: 'love', emoji: '❤️' },
  { type: 'haha', emoji: '😂' }, { type: 'sad', emoji: '😢' },
  { type: 'angry', emoji: '😠' },
]
function toggleReaction(type) {
  const prev = currentReaction.value
  if (prev) localSummary[prev] = Math.max(0, (localSummary[prev] || 0) - 1)
  if (prev === type) { currentReaction.value = null }
  else { currentReaction.value = type; localSummary[type] = (localSummary[type] || 0) + 1 }
  router.post(`/posts/${props.post.id}/reactions`, { type }, { preserveScroll: true, preserveState: true })
}
const commentBody = ref('')
const commentError = ref('')
const submitting = ref(false)
const formattedBody = computed(() => props.post.body.replace(/\n/g, '<br>'))
function submitComment() {
  if (!commentBody.value.trim()) { commentError.value = 'Please write something.'; return }
  submitting.value = true
  router.post(`/posts/${props.post.id}/comments`, { body: commentBody.value }, {
    preserveScroll: true,
    onSuccess: () => { commentBody.value = '' },
    onFinish: () => { submitting.value = false },
  })
}
function deleteComment(id) {
  if (!confirm('Delete your comment?')) return
  router.delete(`/comments/${id}`, { preserveScroll: true })
}
function formatDate(date) {
  return new Date(date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' })
}
function timeAgo(date) {
  const diff = Date.now() - new Date(date).getTime()
  const mins = Math.floor(diff / 60000)
  if (mins < 1) return 'just now'
  if (mins < 60) return `${mins}m ago`
  const hrs = Math.floor(mins / 60)
  if (hrs < 24) return `${hrs}h ago`
  return `${Math.floor(hrs / 24)}d ago`
}
</script>

<style scoped>
.post-view { max-width: 760px; margin: 0 auto; }
.back-link { display: inline-flex; align-items: center; color: #6b6860; text-decoration: none; font-size: 0.875rem; font-weight: 500; margin-bottom: 1.5rem; transition: color 0.15s; }
.back-link:hover { color: #1c1917; }
.flash-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; border-radius: 10px; padding: 0.75rem 1rem; font-size: 0.875rem; margin-bottom: 1.5rem; }
.post-article { background: #fff; border: 1px solid #e8e5e0; border-radius: 18px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.05); margin-bottom: 1.5rem; }
.post-head { padding: 2.5rem 2.5rem 2rem; border-bottom: 1px solid #f0ede8; }
.head-top { display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1rem; }
.type-badge { font-size: 0.75rem; font-weight: 700; padding: 0.28rem 0.75rem; border-radius: 20px; }
.type-badge.announcement { background: #f5f3ff; color: #6d28d9; }
.type-badge.reminder { background: #ecfeff; color: #0e7490; }
.pin-tag { font-size: 0.75rem; font-weight: 600; color: #92400e; }
.post-title { font-size: 2rem; font-weight: 700; letter-spacing: -0.02em; color: #1c1917; line-height: 1.25; margin-bottom: 1.25rem; }
.post-byline { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; }
.byline-author { display: flex; align-items: center; gap: 0.65rem; }
.author-avatar { width: 38px; height: 38px; border-radius: 50%; background: #1c1917; color: #f59e0b; font-size: 0.875rem; font-weight: 700; display: flex; align-items: center; justify-content: center; }
.author-name { display: block; font-size: 0.875rem; font-weight: 600; color: #1c1917; }
.author-label { display: block; font-size: 0.725rem; color: #9c9890; text-transform: uppercase; letter-spacing: 0.05em; }
.byline-meta { display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: #9c9890; flex-wrap: wrap; }
.post-body { padding: 2rem 2.5rem; font-size: 1rem; line-height: 1.85; color: #3d3a36; border-bottom: 1px solid #f0ede8; }
.reaction-bar { padding: 1.5rem 2.5rem; }
.reaction-prompt { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.07em; color: #9c9890; margin-bottom: 0.75rem; }
.reactions { display: flex; gap: 0.5rem; flex-wrap: wrap; }
.react-btn { display: flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; border-radius: 24px; border: 1.5px solid #e8e5e0; background: #f7f5f0; cursor: pointer; font-size: 0.875rem; transition: all 0.15s; }
.react-btn:hover { border-color: #c5c3be; transform: scale(1.05); }
.react-btn.chosen { border-color: #1c1917; background: #1c1917; color: #fff; }
.reaction-feedback { margin-top: 0.75rem; font-size: 0.8rem; color: #9c9890; }
.remove-reaction { background: none; border: none; color: #dc2626; font-size: 0.8rem; cursor: pointer; text-decoration: underline; padding: 0; }
.comments-wrap { background: #fff; border: 1px solid #e8e5e0; border-radius: 18px; padding: 2rem 2.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.05); }
.comments-head { display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1.75rem; }
.comments-title { font-size: 1.25rem; font-weight: 700; color: #1c1917; }
.comment-count-badge { background: #f0ede8; color: #6b6860; border-radius: 20px; padding: 0.1rem 0.6rem; font-size: 0.8rem; font-weight: 600; }
.write-comment { display: flex; gap: 0.875rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #f0ede8; }
.commenter-avatar { width: 36px; height: 36px; border-radius: 50%; background: #f59e0b; color: #1c1917; font-size: 0.8rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.comment-composer { flex: 1; }
.composer-input { width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e8e5e0; border-radius: 12px; background: #f7f5f0; font-size: 0.9rem; color: #1c1917; resize: vertical; transition: border-color 0.15s; font-family: inherit; }
.composer-input:focus { outline: none; border-color: #1c1917; background: #fff; }
.composer-input.has-error { border-color: #dc2626; }
.composer-error { font-size: 0.78rem; color: #dc2626; margin-top: 0.35rem; }
.composer-actions { display: flex; align-items: center; justify-content: flex-end; gap: 0.5rem; margin-top: 0.6rem; }
.char-hint { font-size: 0.775rem; color: #9c9890; margin-right: auto; }
.char-hint.warn { color: #dc2626; font-weight: 600; }
.btn-post-comment { padding: 0.4rem 1.1rem; border-radius: 8px; background: #1c1917; color: #fff; border: none; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: opacity 0.15s; }
.btn-post-comment:hover { opacity: 0.85; }
.btn-post-comment:disabled { opacity: 0.4; cursor: not-allowed; }
.no-comments { text-align: center; padding: 2rem; color: #9c9890; font-size: 0.9rem; }
.comments-list { display: flex; flex-direction: column; gap: 1.25rem; }
.comment-item { display: flex; gap: 0.75rem; }
.cmt-avatar { width: 32px; height: 32px; border-radius: 50%; background: #e8e5e0; color: #6b6860; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.comment-content { flex: 1; }
.cmt-header { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem; flex-wrap: wrap; }
.cmt-name { font-size: 0.875rem; font-weight: 600; color: #1c1917; }
.cmt-you { font-size: 0.7rem; font-weight: 700; background: #f0ede8; color: #6b6860; padding: 0.1rem 0.45rem; border-radius: 10px; }
.cmt-date { font-size: 0.775rem; color: #9c9890; margin-left: auto; }
.cmt-delete { background: none; border: none; cursor: pointer; font-size: 0.8rem; padding: 0.15rem 0.35rem; border-radius: 5px; color: #9c9890; transition: all 0.15s; }
.cmt-delete:hover { background: #fee2e2; color: #dc2626; }
.cmt-body { font-size: 0.9rem; color: #3d3a36; line-height: 1.65; }
</style>
