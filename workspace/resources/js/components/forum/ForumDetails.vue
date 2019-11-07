<template>
    <section class="view controls-primary-view">
        <v-article
            class="p-post"
            v-for="(forum,index) in forums"
            :key="index"
            :post="forum"
            :to="{name:'forum-details', params:{id:forum._id}}"
			:readmore="true"
        ></v-article>
		<div class="comment">
			<div v-for="comment in comments">
				<p class="comment-usericon"><img src="https://3.bp.blogspot.com/-KgUzGDeV8r8/VaMOD3z_X-I/AAAAAAAAvh8/YK5LucKKUmo/s800/boy_01.png"></p>
				<p class="comment-username">{{comment.username}}</p>
			</div>
            <div class="input-wrapper">
                <v-input v-model="text" counter :max="200" multiline>コメント欄</v-input>
            </div>
			<div class="buttons-wrapper">
                <button class="normal-button">投稿</button>
            </div>
		</div>
    </section>
</template>
<script>
import VArticle from "../VArticle.vue";
import VInput from "../VInput";
import VInputMultipleImages from "../VInputMultipleImages";
export default {
    data() {
        return {
            forums: [
                {
                    _id: "l66ec26-3768-48aa-9ca9-a7d604815507",
                    title: "第59回愛媛笑門会",
                    post_member_id: "l66ec26-3768-48aa-9ca9-a7d604815507",
                    post_member_name: "松下",
                    text:
                        "とだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、",
                    images: [
                        "/img/check.svg",
                        "/img/stamp.svg",
                        "/img/profile_image.jpg",
                        "/img/invitation-post-image.jpg"
                    ],
                    created_at: "2019-06-01 16:27:03"
                }
            ],
			comments:
			[
				{usericon: '/img/profile_image.jpg', username: '山田　太郎'}
			]
        };
    },
    created: function() {
        this.$root.loadMembers();
    },
    components: {
        VArticle,
		VInput,
		VInputMultipleImages
    }
};
</script>
<style lang="scss" scoped>
$border-value: solid 1px $gray;
.p-post {
    margin: 32px auto;
}
.comment {
	margin: 32px auto;
	width: 600px;
	height: auto;
	background-color: rgba(0, 0, 0, 0);
	border-radius: 8px;
	box-shadow: 0 2px 1px -1px rgba(0, 0, 0, 0.2),
		0 1px 1px 0 rgba(0, 0, 0, 0.14), 0 1px 3px 0 rgba(0, 0, 0, 0.12);
}
.comment-usericon {
	display: inline;
}
.comment-usericon img{
	display: inline;
	margin-top: 10px;
	margin-left: 20px;
	height: 50px;
	width: 50px;
}
.comment-username {
	display: inline;
	margin-left: 4px;
	vertical-align: 15px;
	
}
.input-wrapper {
	padding: 20px;
}
.buttons-wrapper {
	display: block;
	text-align: right;
	padding-top: 10px;
	padding-right: 20px;
	padding-bottom: 10px;
	border-top: $border-value;
}
</style>