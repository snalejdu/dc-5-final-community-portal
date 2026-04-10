<template>
  <AppLayout>
    <div class="form-page">

      <Link href="/dashboard" class="back-link">← Back to Dashboard</Link>

      <div class="form-card">
        <div class="form-header">
          <h1 class="form-title">Edit Post</h1>
          <p class="form-subtitle">Update your post content and settings</p>
        </div>

        <form @submit.prevent="submit">

          <!-- Type selector -->
          <div class="form-group">
            <label class="form-label">Post Type</label>
            <div class="type-selector">
              <button
                type="button"
                class="type-option"
                :class="{ active: form.type === 'announcement' }"
                @click="form.type = 'announcement'"
              >
                <span class="type-icon">📢</span>
                <span class="type-name">Announcement</span>
                <span class="type-desc">Important news for the community</span>
              </button>
              <button
                type="button"
                class="type-option"
                :class="{ active: form.type === 'reminder' }"
                @click="form.type = 'reminder'"
              >
                <span class="type-icon">🔔</span>
                <span class="type-name">Reminder</span>
                <span class="type-desc">Upcoming events or deadlines</span>
              </button>
            </div>
            <span v-if="form.errors.type" class="field-error">{{ form.errors.type }}</span>
          </div>

          <!-- Title -->
          <div class="form-group">
            <label class="form-label" for="title">Title</label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              class="form-input"
              :class="{ error: form.errors.title }"
              placeholder="Enter a clear, descriptive title..."
              maxlength="255"
            />
            <div class="input-footer">
              <span v-if="form.errors.title" class="field-error">{{ form.errors.title }}</span>
              <span class="char-count">{{ form.title.length }}/255</span>
            </div>
          </div>

          <!-- Body -->
          <div class="form-group">
            <label class="form-label" for="body">Content</label>
            <textarea
              id="body"
              v-model="form.body"
              class="form-textarea"
              :class="{ error: form.errors.body }"
              placeholder="Write the full content of your post..."
              rows="8"
            />
            <span v-if="form.errors.body" class="field-error">{{ form.errors.body }}</span>
          </div>

          <!-- Publish date + pinned -->
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="published_at">Publish Date</label>
              <input
                id="published_at"
                v-model="form.published_at"
                type="datetime-local"
                class="form-input"
              />
              <span class="form-hint">Leave empty to publish immediately</span>
            </div>

            <div class="form-group">
              <label class="form-label">Options</label>
              <label class="toggle-label">
                <input
                  v-model="form.pinned"
                  type="checkbox"
                  class="toggle-input"
                />
                <span class="toggle-track">
                  <span class="toggle-thumb"></span>
                </span>
                <span class="toggle-text">Pin this post to the top of the feed</span>
              </label>
            </div>
          </div>

          <!-- Dirty warning -->
          <div v-if="form.isDirty" class="dirty-warning">
            ⚠️ You have unsaved changes.
          </div>

          <!-- Actions -->
          <div class="form-actions">
            <Link :href="`/posts/${post.id}`" class="btn-cancel">Cancel</Link>
            <button
              type="submit"
              class="btn-submit"
              :disabled="form.processing || !form.isDirty"
            >
              {{ form.processing ? 'Saving...' : 'Save Changes' }}
            </button>
          </div>

        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  post: Object,
})

const form = useForm({
  type: props.post.type,
  title: props.post.title,
  body: props.post.body,
  pinned: props.post.pinned,
  published_at: props.post.published_at
    ? new Date(props.post.published_at).toISOString().slice(0, 16)
    : '',
})

function submit() {
  form.put(`/posts/${props.post.id}`)
}
</script>

<style scoped>
.form-page { max-width: 720px; margin: 0 auto; }

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

.form-card {
  background: var(--surface-solid);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 2.5rem;
  box-shadow: var(--shadow);
}

.form-header { margin-bottom: 2rem; }

.form-title {
  font-family: 'DM Serif Display', serif;
  font-size: 1.75rem;
  font-weight: 400;
  letter-spacing: -0.02em;
  margin-bottom: 0.35rem;
}

.form-subtitle {
  font-size: 0.875rem;
  color: var(--text-muted);
}

.form-group { margin-bottom: 1.5rem; }

.form-label {
  display: block;
  font-size: 0.85rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: var(--text);
}

.type-selector {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.75rem;
}

.type-option {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 0.2rem;
  padding: 1rem 1.25rem;
  border: 2px solid var(--border);
  border-radius: var(--radius-sm);
  background: var(--bg);
  cursor: pointer;
  text-align: left;
  transition: all 0.15s;
}

.type-option:hover { border-color: var(--border-strong); }
.type-option.active { border-color: var(--accent); background: var(--accent-light); }

.type-icon { font-size: 1.4rem; margin-bottom: 0.2rem; }
.type-name { font-size: 0.9rem; font-weight: 700; color: var(--text); }
.type-desc { font-size: 0.775rem; color: var(--text-muted); }

.form-input, .form-textarea {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid var(--border);
  border-radius: var(--radius-sm);
  background: var(--bg);
  font-size: 0.9rem;
  color: var(--text);
  transition: border-color 0.15s;
}

.form-input:focus, .form-textarea:focus {
  outline: none;
  border-color: var(--accent);
  background: #fff;
}

.form-input.error, .form-textarea.error { border-color: var(--danger); }
.form-textarea { resize: vertical; min-height: 180px; }

.input-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 0.4rem;
}

.char-count { font-size: 0.775rem; color: var(--text-light); margin-left: auto; }
.form-hint { font-size: 0.775rem; color: var(--text-light); margin-top: 0.35rem; display: block; }
.field-error { font-size: 0.8rem; color: var(--danger); display: block; }

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
}

.toggle-label {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  cursor: pointer;
  margin-top: 0.25rem;
}

.toggle-input { display: none; }

.toggle-track {
  position: relative;
  width: 40px;
  height: 22px;
  background: var(--border-strong);
  border-radius: 11px;
  transition: background 0.2s;
  flex-shrink: 0;
}

.toggle-input:checked + .toggle-track { background: var(--accent); }

.toggle-thumb {
  position: absolute;
  top: 3px;
  left: 3px;
  width: 16px;
  height: 16px;
  background: #fff;
  border-radius: 50%;
  transition: transform 0.2s;
  box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

.toggle-input:checked + .toggle-track .toggle-thumb { transform: translateX(18px); }
.toggle-text { font-size: 0.85rem; color: var(--text-muted); }

.dirty-warning {
  background: var(--warning-light);
  color: var(--warning);
  border: 1px solid #fde68a;
  border-radius: var(--radius-sm);
  padding: 0.6rem 1rem;
  font-size: 0.85rem;
  font-weight: 500;
  margin-bottom: 1rem;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
  padding-top: 1.5rem;
  border-top: 1px solid var(--border);
}

.btn-cancel {
  padding: 0.6rem 1.25rem;
  border-radius: var(--radius-sm);
  border: 1px solid var(--border);
  background: var(--bg);
  color: var(--text-muted);
  font-size: 0.9rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.15s;
}

.btn-cancel:hover { border-color: var(--border-strong); color: var(--text); }

.btn-submit {
  padding: 0.6rem 1.5rem;
  background: var(--accent);
  color: #fff;
  border: none;
  border-radius: var(--radius-sm);
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: opacity 0.15s;
}

.btn-submit:hover { opacity: 0.88; }
.btn-submit:disabled { opacity: 0.5; cursor: not-allowed; }
</style>
