   let headersPost=document.querySelectorAll('.userImages');
	  const canvas=document.createElement('canvas');
		    const MAX_Width=100;
	 headersPost.forEach((header)=>{
		 let imageElement=header.querySelector('img');
		 if(imageElement){
			let img = new Image();
			img.src=imageElement.src;
		   img.onload=function(e){
			  const scaleSize=MAX_Width/e.target.width;
			  canvas.width=MAX_Width;
			  canvas.height=e.target.height * scaleSize;
			  var ctx = canvas.getContext("2d");
			  ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);
			  var dataurl = canvas.toDataURL("image/png");
			  imageElement.src=dataurl;
			  //console.log(canvas)
			  
		   }

		 }
		 
	 })
	 
