<template>
  <div>
    <div class="card-top">
      <span class="type-badge" :class="post.type">
        {{ post.type === 'announcement' ? '📢' : '🔔' }} {{ post.type }}
      </span>
      <span v-if="post.pinned" class="pin-label">📌 Pinned</span>
      <span class="post-date">{{ formatDate(post.published_at) }}</span>
    </div>
    <h2 class="card-title">{{ post.title }}</h2>
    <p class="card-excerpt">{{ excerpt(post.body) }}</p>
    <div class="card-footer">
      <div class="author-row">
        <span class="author-dot">{{ post.author.name.charAt(0).toUpperCase() }}</span>
        <span class="author-name">{{ post.author.name }}</span>
      </div>
      <div class="card-stats">
        <span>💬 {{ post.comments_count }}</span>
        <span>❤️ {{ post.reactions_count }}</span>
        <span>👁 {{ post.views_count }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({ post: Object })
function excerpt(body) { return body.length > 150 ? body.slice(0, 150) + '…' : body }
function formatDate(date) {
  return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
}
</script>

<style scoped>
.card-top { display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.75rem; flex-wrap: wrap; }
.type-badge { font-size: 0.72rem; font-weight: 700; text-transform: capitalize; padding: 0.22rem 0.65rem; border-radius: 20px; }
.type-badge.announcement { background: #f5f3ff; color: #6d28d9; }
.type-badge.reminder { background: #ecfeff; color: #0e7490; }
.pin-label { font-size: 0.72rem; font-weight: 600; color: #92400e; }
.post-date { font-size: 0.75rem; color: #9c9890; margin-left: auto; }
.card-title { font-size: 1.2rem; font-weight: 600; color: #1c1917; margin-bottom: 0.5rem; line-height: 1.4; }
.card-excerpt { font-size: 0.875rem; color: #6b6860; line-height: 1.65; margin-bottom: 1.1rem; }
.card-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 0.875rem; border-top: 1px solid #f0ede8; }
.author-row { display: flex; align-items: center; gap: 0.5rem; }
.author-dot { width: 24px; height: 24px; border-radius: 50%; background: #1c1917; color: #fff; font-size: 0.65rem; font-weight: 700; display: flex; align-items: center; justify-content: center; }
.author-name { font-size: 0.8rem; font-weight: 500; color: #6b6860; }
.card-stats { display: flex; gap: 0.875rem; font-size: 0.78rem; color: #9c9890; }
</style>
