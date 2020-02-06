function authorization(req, res, next) {
    if (!req.session.memberId) {
        res.status(401).json({ result: false });
    } else {
        next();
    }
}

function adminAuthorization (req, res, next) {
    if (req.session.isAdmin) {
        next();
    } else {
        res.status(401).json({ result: false });
    }
}

function adminOrMineAuthorization (req, res, next) {
    if (req.session.isAdmin || req.params.id == req.session.memberId) {
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