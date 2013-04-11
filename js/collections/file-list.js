var app = app || {};

app.FileListCollection = Backbone.Collection.extend({
	model : app.FileModel,
	url : ""
});