function authorization(req, res, next) {
    if (!req.session.member) {
        res.status(401).json({ result: false });
    } else {
        next();
    }
}

function adminAuthorization (req, res, next) {
    if (req.session.member.isAdmin) {
        next();
    } else {
        res.status(401).json({ result: false });
    }
}

function adminOrMineAuthorization (req, res, next) {
    if (req.session.member.isAdmin || req.params.id == req.session.member._id) {
        next();
    } else {
        res.status(401).json({ result: false });
    }
}

module.exports = {
    authorization,
    adminAuthorization,
    adminOrMineAuthorization
}