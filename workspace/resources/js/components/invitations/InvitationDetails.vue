<template>
    <section class="view controls-primary-view">
        <v-article
            class="p-post"
            v-for="(invitation,index) in forums"
            :key="index"
            :post="invitation"
            :to="{name:'invitation-details', params:{id:invitation._id}}"
        ></v-article>
		<div class="attendance-selection">
			<h2 class="attendance-selection-title">出欠席選択</h2>
			<div class="precautions">
				<p class="due-date">締め切り日:</p>
				<p class="important point"><font color="#B92D00">※締め切り日までに選択されなかった場合「未回答」となります。</font></p>
			</div>
			<div class="selection-field">
				<input type="radio" id="attendance" value="Attendance">
				<label for="attendance">出席する</label><br>
				<input type="radio" id="absence" value="Absence">
				<label for="absence">欠席する</label>
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
.attendance-selection {
	margin: 32px auto;
	width: 600px;
	height: 230px;
	background-color: rgba(0, 0, 0, 0);
	box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
}
.attendance-selection-title {
	padding: 10px;
}
.precautions {
	padding: 10px;
	border-top: 2px solid #eee;
	line-height: 20px;
}
.selection-field {
	padding: 6px;
	line-height: 30px;
}
.buttons-wrapper {
	padding: 8px 14px;
	border-top: 2px solid #eee;
}
</style>