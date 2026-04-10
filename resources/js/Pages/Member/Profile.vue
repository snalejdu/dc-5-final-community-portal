<template>
  <MemberLayout>
    <div class="profile-page">
      <div class="profile-hero">
        <div class="profile-avatar">{{ initials }}</div>
        <div class="profile-info">
          <h1 class="profile-name">{{ user.name }}</h1>
          <p class="profile-email">{{ user.email }}</p>
          <span class="member-badge">Community Member</span>
        </div>
        <div class="profile-summary">
          <div class="summary-stat">
            <span class="sval">{{ stats.comments }}</span>
            <span class="slabel">Comments</span>
          </div>
          <div class="sdivider"></div>
          <div class="summary-stat">
            <span class="sval">{{ stats.reactions }}</span>
            <span class="slabel">Reactions</span>
          </div>
          <div class="sdivider"></div>
          <div class="summary-stat">
            <span class="sval">{{ stats.posts_viewed }}</span>
            <span class="slabel">Posts Read</span>
          </div>
        </div>
      </div>

      <div class="profile-body">
        <div class="permissions-card">
          <h2 class="card-heading">Your Permissions</h2>
          <div class="perms">
            <div class="perm allowed">✅ View all announcements & reminders</div>
            <div class="perm allowed">✅ Comment on any post</div>
            <div class="perm allowed">✅ React to any post</div>
            <div class="perm allowed">✅ Delete your own comments</div>
            <div class="perm denied">🚫 Create posts (admin only)</div>
            <div class="perm denied">🚫 Edit or delete others' content</div>
          </div>
        </div>

        <div class="activity-card">
          <h2 class="card-heading">Recent Comments</h2>
          <div v-if="recentComments.length === 0" class="empty-activity">
            <p>💬 No comments yet.</p>
            <Link href="/feed" class="go-feed">Browse the feed →</Link>
          </div>
          <div v-else class="activity-list">
            <div v-for="comment in recentComments" :key="comment.id"
              class="activity-item" @click="router.visit(`/posts/${comment.post_id}`)">
              <div class="activity-icon">💬</div>
              <div>
                <p class="activity-post-title">{{ comment.post?.title }}</p>
                <p class="activity-text">"{{ excerpt(comment.body) }}"</p>
                <span class="activity-date">{{ timeAgo(comment.created_at) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MemberLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'

const props = defineProps({ stats: Object, recentComments: Array })
const page = usePage()
const user = computed(() => page.props.auth.user)
const initials = computed(() =>
  user.value.name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
)
function excerpt(text) { return text.length > 80 ? text.slice(0, 80) + '…' : text }
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
.profile-page { max-width: 820px; margin: 0 auto; }
.profile-hero { background: #1c1917; border-radius: 18px; padding: 2.5rem; display: flex; align-items: center; gap: 2rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
.profile-avatar { width: 72px; height: 72px; border-radius: 50%; background: #f59e0b; color: #1c1917; font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.profile-info { flex: 1; }
.profile-name { font-size: 1.75rem; font-weight: 700; color: #fff; letter-spacing: -0.02em; margin-bottom: 0.2rem; }
.profile-email { font-size: 0.875rem; color: rgba(255,255,255,0.45); margin-bottom: 0.6rem; }
.member-badge { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; background: rgba(245,158,11,0.15); color: #f59e0b; padding: 0.25rem 0.7rem; border-radius: 20px; border: 1px solid rgba(245,158,11,0.3); }
.profile-summary { display: flex; align-items: center; gap: 1.75rem; flex-shrink: 0; }
.summary-stat { text-align: center; }
.sval { display: block; font-size: 1.75rem; font-weight: 700; color: #fff; line-height: 1.1; }
.slabel { display: block; font-size: 0.7rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.06em; margin-top: 0.2rem; }
.sdivider { width: 1px; height: 36px; background: rgba(255,255,255,0.1); }
.profile-body { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.permissions-card, .activity-card { background: #fff; border: 1px solid #e8e5e0; border-radius: 14px; padding: 1.75rem; }
.card-heading { font-size: 0.95rem; font-weight: 700; color: #1c1917; margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 1px solid #f0ede8; }
.perms { display: flex; flex-direction: column; gap: 0.6rem; }
.perm { font-size: 0.875rem; }
.perm.allowed { color: #1c1917; }
.perm.denied { color: #c5c3be; }
.empty-activity { text-align: center; padding: 2rem 1rem; color: #9c9890; font-size: 0.875rem; }
.go-feed { color: #1c1917; font-weight: 600; text-decoration: none; font-size: 0.875rem; }
.activity-list { display: flex; flex-direction: column; gap: 0.875rem; }
.activity-item { display: flex; gap: 0.75rem; padding: 0.875rem; background: #f7f5f0; border-radius: 10px; cursor: pointer; transition: background 0.15s; }
.activity-item:hover { background: #f0ede8; }
.activity-icon { font-size: 1.1rem; flex-shrink: 0; }
.activity-post-title { font-size: 0.8rem; font-weight: 600; color: #1c1917; margin-bottom: 0.25rem; }
.activity-text { font-size: 0.8rem; color: #6b6860; font-style: italic; margin-bottom: 0.3rem; }
.activity-date { font-size: 0.72rem; color: #9c9890; }
</style>
