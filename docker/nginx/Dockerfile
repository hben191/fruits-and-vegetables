FROM nginx:alpine

# Supprimer la conf par défaut et ajouter la nôtre
RUN rm /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/conf.d

WORKDIR /var/www/app