import{bJ as u,bz as i,aK as r,u as n,v as d,b9 as c,bo as m,aS as p,aC as f,by as _}from"./app-fLTEigqr.js";const g={class:"text-sm text-red-600"},x={__name:"InputError",props:{message:{type:String}},setup(e){return(a,t)=>u((r(),n("div",null,[d("p",g,c(e.message),1)],512)),[[i,e.message]])}},y={__name:"TextInput",props:{modelValue:{type:String,required:!0},modelModifiers:{}},emits:["update:modelValue"],setup(e,{expose:a}){const t=m(e,"modelValue"),s=p(null);return f(()=>{s.value.hasAttribute("autofocus")&&s.value.focus()}),a({focus:()=>s.value.focus()}),(v,o)=>u((r(),n("input",{class:"border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm","onUpdate:modelValue":o[0]||(o[0]=l=>t.value=l),ref_key:"input",ref:s},null,512)),[[_,t.value]])}};export{y as _,x as a};
