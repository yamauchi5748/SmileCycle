const nodemailer = require('nodemailer');

const smtpConfig = {
    host: 'smtp.gmail.com',
    port: 465,
    secure: true, // SSL
    auth: {
        user: '',
        pass: ''
    }
};
const transporter = nodemailer.createTransport(smtpConfig);

module.exports = {
    send(members, { type, url }) {
        // メッセージ
        const message = {
            from: 'SmileCycle01',
            bcc: members.map(member => member.mail),
            subject: type == 'unreadchat' ? '未読チャットがあります！' : type == 'hurrychat' ? '急ぎチャットが届きました！' : '新しい会のご案内が届きました！',
            text: type == 'unreadchat' ?
            /* chat */    `笑門会、SmileCycle.netからお知らせです。\n未読のチャットがあります。確認するには以下のリンクを押下してください。\n${url}\n笑門会のコミュニティサイト` : 
            type == 'hurrychat' ? 
            /* hurrychat */ `笑門会、SmileCycle.netからお知らせです。\n急ぎチャットが届きました。確認するには以下のリンクを押下してください。\n${url}\n笑門会のコミュニティサイト` : 
            /* invitation */    `新しい会のご案内が届きました。\n確認するには以下のリンクを押下してください。\n${url}\n笑門会のコミュニティサイト`
        };
        transporter.sendMail(message, function (err, response) {
            console.log(err || response);
        });
    }
}