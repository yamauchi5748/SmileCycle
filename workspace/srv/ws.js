const debug = require("debug")("app:ws");
const { ObjectId } = require("mongoose");
const io = require("socket.io")(5000, {
    origins: "*:*",
    cookie: false
});

io.on("connect", socket => {

});

const { Member } = require("./model");
Member.watch().on("change", async change => {
    const { operationType, documentKey: { _id: documentId } } = change;
    const obj = {
        operationType,
        documentId
    };
    if (operationType != "delete") {
        const document = await Member
            .findOne({ _id: documentId }, "-_id -password")
            .exec();
        obj.document = document;
    }
    io.emit("members", obj);
});
const { Company } = require("./model");
Company.watch().on("change", async change => {
    submitChanges("companies", Company, change);
});
const { Invitation } = require("./model");
Invitation.watch().on("change", async change => {
    const { operationType, documentKey: { _id: documentId } } = change;
    const obj = {
        operationType,
        documentId
    };
    if (operationType != "delete") {
        const document = await Invitation.aggregate()
            .match({ _id: documentId })
            .lookup({
                from: "members",
                localField: "members",
                foreignField: "_id",
                as: "members_temp"
            })
            .project({
                _id: 1,
                title: 1,
                text: 1,
                images: 1,
                members: 1,
                deadline_at: 1,
                created_at: 1,
                statusTable: 1,
                membersTable: {
                    $arrayToObject: {
                        $map: {
                            input: "$members_temp",
                            in: {
                                k: { $toString: "$$this._id" }, v: {
                                    avatar: "$$this.avatar",
                                    name: "$$this.name",
                                    ruby: "$$this.ruby",
                                }
                            }
                        }
                    }
                }
            })
            .exec();
        obj.document = document[0];
    }
    io.emit("invitations", obj);
});
const { Timeline } = require("./model");
Timeline.watch().on("change", async change => {
    const { operationType, documentKey: { _id: documentId } } = change;
    const obj = {
        operationType,
        documentId
    };
    if (operationType != "delete") {
        const document = await Timeline
            .findOne({ _id: documentId }, "-_id")
            .exec();
        obj.document = document;
    }
    io.emit("timelines", obj);
});
const { Comment } = require("./model");
Comment.watch().on("change", async change => {
    const { operationType, documentKey: { _id: documentId } } = change;
    const obj = {
        operationType,
        documentId
    };
    if (operationType != "delete") {
        const document = await Comment
            .findOne({ _id: documentId }, "-_id")
            .exec();
        obj.document = document;
    }
    io.emit("comments", obj);
});
const { Room } = require("./model");
Room.watch().on("change", async change => {
    debug(change);
    const { operationType, documentKey: { _id: documentId } } = change;
    const obj = {
        operationType,
        documentId
    };
    if (operationType != "delete") {
        const document = await Room
            .findOne({ _id: documentId }, "-_id")
            .exec();
        obj.document = document;
    }
    io.emit("rooms", obj);
});
const { Content } = require("./model");
Content.watch().on("change", async change => {
    const { operationType, documentKey: { _id: documentId } } = change;
    const obj = {
        operationType,
        documentId
    };
    if (operationType != "delete") {
        const document = await Content.aggregate()
            .match({ _id: documentId })
            .project({
                _id: 0,
                roomId: 1,
                alreadyReadCount: { $size: "$alreadyReadList" },
                senderId: 1,
                name: 1,
                avatar: 1,
                message: 1,
                stamp: 1,
                image: 1,
                contentType: 1,
                created_at: 1,
            })
            .exec();
        obj.document = document[0];
    }
    io.emit("contents", obj);
});
const { Stamp } = require("./model");
Stamp.watch().on("change", async change => {
    submitChanges("stamps", Stamp, change);
});

async function submitChanges(eventName, model, change) {
    const { operationType, documentKey: { _id } } = change;
    const obj = {
        operationType,
        documentId: _id
    }
    if (operationType != "delete") {
        const document = await model.findOne({ _id }).select("-_id").exec();
        obj.document = document;
    }
    io.emit(eventName, obj);
}