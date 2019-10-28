<template>
  <ol class="p-room-contents__list" v-if="!contents[0].is_none">
    <li
      class="p-room-contents__list-item layout-flex"
      v-for="(content, index) in contents"
      :key="index"
    >
      <figure class="p-flex--left">
        <img
          class="p-room-contents__profile"
          :src="'/members/' + content.sender_id + '/profile-image'"
          alt="profile"
        />
      </figure>
      <div class="p-flex--right">
        <div class="p-room-contents__signature layout-flex margin-bottom-small">
          <span class="p-room-contents__signature-name">{{ content.sender_name }}</span>
          <time
            class="p-room-contents__signature-date margin-left-small"
            :datetime="content.created_at"
          >{{ content.created_at }}</time>
        </div>
        <p class="p-room-contents__text" v-if="content.content_type == '1'">{{ content.message }}</p>
        <img
          class="p-room-contents__image"
          :src="'/stamp-images/' + content.stamp_id"
          alt="スタンプ"
          v-if="content.content_type == '2'"
        />
        <img
          class="p-room-contents__image"
          :src="'/chat-rooms/' + room_id + '/images/' + content.content_id"
          alt="画像"
          v-if="content.content_type == '3'"
        />
      </div>
    </li>
  </ol>
</template>
<script>
export default {
  props: {
    contents: Array,
    room_id: String
  }
};
</script>
<style lang="scss" scoped>
.p-room-contents {
  &__list {
    height: 100%;
    padding: 20px;
  }

  &__list-item {
    width: 100%;
    margin-bottom: 20px;
  }

  &__profile {
    width: 57px;
    height: 57px;
    border-radius: 50%;
  }

  &__signature-name {
    font-size: 18px;
    font-weight: bold;
  }

  &__signature-date {
    font-size: 13px;
  }

  &__text {
    font-size: 16px;
    font-weight: bold;
    color: #444444;
    white-space: pre-wrap;
    word-break: break-all;
  }

  &__image {
    width: 140px;
    height: 140px;
  }
}
</style>
