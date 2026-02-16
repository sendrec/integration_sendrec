<template>
	<a
		:href="richObject.watchUrl"
		target="_blank"
		rel="noopener noreferrer"
		class="sendrec-widget">
		<div v-if="richObject.thumbnailUrl" class="sendrec-widget__thumbnail">
			<img :src="richObject.thumbnailUrl" :alt="richObject.title">
		</div>
		<div class="sendrec-widget__content">
			<h3 class="sendrec-widget__title">
				{{ richObject.title }}
			</h3>
			<p class="sendrec-widget__meta">
				{{ richObject.authorName }} · {{ formattedDuration }}
			</p>
		</div>
	</a>
</template>

<script>
export default {
	name: 'SendRecReferenceWidget',
	props: {
		richObject: {
			type: Object,
			required: true,
		},
	},

	computed: {
		formattedDuration() {
			const d = this.richObject.duration || 0
			const m = Math.floor(d / 60)
			const s = d % 60
			return `${m}:${String(s).padStart(2, '0')}`
		},
	},
}
</script>

<style scoped>
.sendrec-widget {
	display: flex;
	align-items: center;
	gap: 12px;
	padding: 12px;
	border: 1px solid var(--color-border);
	border-radius: var(--border-radius-large);
	text-decoration: none;
	color: var(--color-main-text);
}

.sendrec-widget:hover {
	background: var(--color-background-hover);
}

.sendrec-widget__thumbnail img {
	width: 120px;
	height: 68px;
	object-fit: cover;
	border-radius: var(--border-radius);
}

.sendrec-widget__title {
	margin: 0;
	font-size: 14px;
	font-weight: 600;
}

.sendrec-widget__meta {
	margin: 4px 0 0;
	font-size: 12px;
	color: var(--color-text-maxcontrast);
}
</style>
