<template>
    <section class="view controls-primary-view">
        <v-article
            class="p-post"
            v-for="(invitation,index) in forums"
            :key="index"
            :post="invitation"
            :to="{name:'invitation-details', params:{id:invitation._id}}"
			:readmore="true"
        ></v-article>
		<div class="comment">
			<div v-for="comment in comments">
				<img src={comment.img}/> {{comment.name}}
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
                    sender_id: "l66ec26-3768-48aa-9ca9-a7d604815507",
                    sender_name: "松下",
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
				{img: '/', name: 'testname'}
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
.p-post {
    margin: 32px auto;
}
.comment {
	margin: 32px auto;
	width: 600px;
	height: 330px;
	background-color: rgba(0, 0, 0, 0);
	box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
}
.buttons-wrapper {
	padding: 8px 14px;
	border-top: 2px solid #eee;
}
</style>