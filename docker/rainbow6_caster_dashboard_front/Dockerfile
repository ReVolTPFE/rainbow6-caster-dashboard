FROM node:18.7.0-buster

RUN npm install -g pnpm npm-check-updates

RUN pnpm config set store-dir /.pnpm-store

WORKDIR /app

COPY . /app

EXPOSE 3000

ENTRYPOINT ["npm", "run"]
CMD ["dev"]