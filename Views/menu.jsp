<%@ page language="java" import="java.util.*" pageEncoding="utf-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<div class="mainmenu">
	<ul class="menu">
		<c:forEach items="${menudata.data}" var="item">
			<c:if test="${item.type == '0'}">
				<li class="menugroup">
					<div class="title"><i class="iconlist icon-reorder"></i><span>${item.name == null?"NULL":item.name}</span><i class="iconarrow icon-angle-right"></i></div>
					<ul>
						<c:forEach items="${item.data}" var="item1">
							<li class="menuitem">
								<div class="title"><span>${item1.name == null?"NULL":item1.name}</span></div>
							</li>
						</c:forEach>
					</ul>
				</li>
			</c:if>
			<c:if test="${item.type == '1'}">
				<li class="menugroup">
					<div class="title"><span>${item.name == null?"NULL":item.name}</span></div>
				</li>
			</c:if>
		</c:forEach>
	</ul>
</div>