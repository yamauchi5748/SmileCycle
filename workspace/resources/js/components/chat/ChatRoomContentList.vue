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
        <div
          class="p-room-contents__signature layout-flex --align-items-center margin-bottom-small"
        >
          <span class="p-room-contents__signature-name">{{ content.sender_name }}</span>
          <time
            class="p-room-contents__signature-date margin-left-small"
            :datetime="content.created_at"
          >{{ content.created_at }}</time>
        </div>
        <div class="p-room-contents__box layout-flex --align-items-flex-end">
          <div class="p-room-contents__wrapper">
            <div class="p-room-contents__wrapper-layout" v-if="content.content_type == '1'"></div>
            <div class="p-room-contents__inner--text" v-if="content.content_type == '1'">
              <p class="p-room-contents__text">{{ content.message }}</p>
            </div>
            <figure class="p-room-contents__inner--image" v-if="content.content_type !== '1'">
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
            </figure>
          </div>
          <span
            class="p-room-contents__read margin-bottom-small"
            v-if="content.already_read >= 0"
          >既読{{ content.already_read }}</span>
        </div>
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
    font-size: 20px;
    font-weight: bold;
  }

  &__signature-date {
    font-size: 15px;
  }

  &__wrapper {
    display: inline-block;
    position: relative;
    margin: 8px;
  }

  &__wrapper-layout {
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    margin-left: -10px;
    margin-top: -10px;
    position: absolute;
    z-index: 1;
    background: radial-gradient(
      circle at 50% 0%,
      transparent 65%,
      rgba(255, 209, 140) 65%
    );
  }

  &__inner {
    &--text {
      background-color: rgba(255, 209, 140);
      border-radius: 13px;
      display: inline-block;
      padding: 5px 10px;
      z-index: 3;
      position: relative;
      word-wrap: break-word;
      max-width: 200px;
    }

    &--image {
    }
  }

  &__text {
    font-size: 18px;
    color: black;
    white-space: pre-wrap;
    word-break: break-all;
  }

  &__image {
    width: 140px;
    height: 140px;
    border-radius: 10px;
  }

  &__read {
    font-size: 15px;
    white-space: nowrap;
  }
}
</style>
