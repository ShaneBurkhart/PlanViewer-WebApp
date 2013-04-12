var app = app || {};

app.PageItemView = Backbone.View.extend({
	tagName : "li",
	className : "page-container row-fluid",
	template : _.template(app.Templates["page-item"]),

	events : {
		"click .controls .up" : "moveUp",
		"click .controls .down" : "moveDown",
		"click .controls .remove" : "delete"
	}, 

	delete : function(e){
		e.preventDefault();
		console.log(this.model.id);
		this.model.destroy();
		this.remove();
	},

	moveUp : function(e){
		e.preventDefault();
		var newPageNum = this.model.get("pageNum") + 1;
		this.model.set("pageNum", newPageNum);
		this.model.save();
	},

	getParent : function(e){
		var pageContainer = $(e.target);
		while(pageContainer.attr("class") != this.className)
			pageContainer = pageContainer.parent();
		return pageContainer;
	},

	render : function(){
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	}
});