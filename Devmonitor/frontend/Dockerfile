# Multi-stage build for optimized production image
FROM node:20-alpine AS builder

LABEL maintainer="DevMonitor Team"
LABEL version="1.0"

# Set working directory
WORKDIR /app

# Install dependencies for node-gyp if needed
RUN apk add --no-cache \
    python3 \
    make \
    g++

# Copy package files
COPY package*.json ./

# Install dependencies with clean install
RUN npm ci --only=production --ignore-scripts \
    && npm cache clean --force

# Copy application source
COPY . .

# Build application for production (uncomment for production build)
# RUN npm run build

# Development stage
FROM node:20-alpine

WORKDIR /app

# Install dumb-init for proper signal handling
RUN apk add --no-cache dumb-init

# Create non-root user
RUN addgroup -g 1001 -S nodejs \
    && adduser -S nodejs -u 1001

# Copy package files
COPY package*.json ./

# Install all dependencies including dev dependencies for development
RUN npm ci \
    && npm cache clean --force

# Copy application files
COPY --chown=nodejs:nodejs . .

# Create necessary directories
RUN mkdir -p node_modules/.cache \
    && chown -R nodejs:nodejs /app

# Switch to non-root user
USER nodejs

# Expose port 3000
EXPOSE 3000

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=60s --retries=3 \
    CMD node healthcheck.js || exit 1

# Use dumb-init to handle signals properly
ENTRYPOINT ["dumb-init", "--"]

# Start React development server
CMD ["npm", "start"]

# Production stage (uncomment for production)
# FROM nginx:alpine AS production
# COPY --from=builder /app/build /usr/share/nginx/html
# COPY docker/nginx/frontend.conf /etc/nginx/conf.d/default.conf
# EXPOSE 80
# CMD ["nginx", "-g", "daemon off;"]