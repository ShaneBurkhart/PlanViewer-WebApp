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
		this.model.destroy();
		this.remove();
	},

	move : function(up){
		var newPageNum, dir;
		if(up){
			newPageNum = this.model.get("pageNum") - 1;
			dir = "up";
		}else{	
			newPageNum = this.model.get("pageNum") + 1;	
			dir = "down";
		}
		this.model.set("pageNum", newPageNum);
		var data = this.model.toJSON();
		data = _.extend(data, {direction : dir});
		this.model.save(data);
	},

	moveUp : function(e){
		e.preventDefault();
		this.move(1);
	},

	moveDown : function(e){
		e.preventDefault();
		this.move(0);
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