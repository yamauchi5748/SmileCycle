FROM centos:centos7
MAINTAINER "shomonkai"

ENV TIMEZONE Asia/Tokyo

ENV HOST_NAME smtp.example.com
ENV DOMAIN_NAME example.com

ENV MESSAGE_SIZE_LIMIT 10240000

ENV AUTH_USER user
ENV AUTH_PASSWORD password

ENV DISABLE_SMTP_AUTH_ON_PORT_25 true

# SMTP
EXPOSE 25
# Submission
EXPOSE 587
# SMTPS
EXPOSE 465

# update yum
RUN yum update -y && \
    yum clean all

# epel repo
RUN yum install -y epel-release && \
    yum clean all

RUN yum install -y httpd php && \
    yum clean all && \
    systemctl enable httpd.service

CMD /sbin/init
