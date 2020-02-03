// レプリカセットの初期化
rs.initiate();
// セカンダリーとあービーターをレプリカセットの中に追加
rs.add({ host: 'mongo-secondary:27017' });
rs.add({ host: 'mongo-arbiter:27017', arbiterOnly: true });
