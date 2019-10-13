<template>
    <section class="view controls-primary-view">
        <v-article
            class="p-post"
            :key="index"
            :post="invitation"
            :to="{name:'invitation-details', params:{id:invitation._id}}"
			:readmore="true"
        ></v-article>
		<ul class="attendance">
			<h2 class="attendance-list">出欠状況</h2>
			<li v-for="user in users">
				<p class="Invitations-user-name">氏名:　{{user.name}}</p>
				<p class="Invitations-user-ruby">ふりがな: {{user.ruby}}</p>
				<p class="Invitations-user-select">{{user.select}}</p>
			</li>
		</ul>
		<div class="attendance-selection">
			<h2 class="attendance-selection-title">出欠席選択</h2>
			<div class="precautions">
				<p class="duedate">締め切り日:<time>{{ duedate }}</time></p>
				<p class="important point"><font color="#B92D00">※締め切り日までに選択されなかった場合「未回答」となります。</font></p>
			</div>
			<div class="selection-field">
				<p>
				<input type="radio" name="q1" value="出席する"> 出席する<br/>
				<input type="radio" name="q1" value="欠席する"> 欠席する
				</p>
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
			invitation:
			{
				_id: "l66ec26-3768-48aa-9ca9-a7d604815507",
				title: "第59回愛媛笑門会",
				sender_id: "l66ec26-3768-48aa-9ca9-a7d604815507",
				sender_name: "松下",
				text: "とだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、本日はお日柄もよく非常に過ごしやすくなっております。皆様のますますのご活躍のことだと存じます、、、、",
				images: [
					"/img/check.svg",
					"/img/stamp.svg",
					"/img/profile_image.jpg",
					"/img/invitation-post-image.jpg"
				],
				created_at: "2019-06-01 16:27:03"
			},
			users:
			[
				{ name: '山田 太郎', ruby: '(やまだ たろう)様', select: 'ご出席' },
				{ name: '山田 太郎', ruby: '(やまだ たろう)様', select: 'ご出席' },
				{ name: '山田 太郎', ruby: '(やまだ たろう)様', select: 'ご出席' },
				{ name: '山田 太郎', ruby: '(やまだ たろう)様', select: 'ご出席' },
				{ name: '山田 太郎', ruby: '(やまだ たろう)様', select: 'ご出席' },
				{ name: '山田 太郎', ruby: '(やまだ たろう)様', select: 'ご出席' },
				{ name: '山田 太郎', ruby: '(やまだ たろう)様', select: 'ご出席' },
				{ name: '山田 太郎', ruby: '(やまだ たろう)様', select: 'ご出席' }

			],
			duedate: '2019/12/31'
		}
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
.attendance {
	display: table;
	margin: 32px auto;
	width: 600px;
	line-height: 26px;
	background-color: #baf9af
}
.attendance-list {
	padding: 10px;
}
.Invitations-user-name {
	display: inline;
	margin-left: 20px;
}
.Invitations-user-ruby {
	display: inline;
	margin-left: 40px;
}
.Invitations-user-select {
	display: inline;
	float: right;
	margin-right: 40px;
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