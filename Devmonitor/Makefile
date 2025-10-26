# ============================================
# DevMonitor - Makefile
# Development Commands for Docker Environment
# ============================================

.DEFAULT_GOAL := help
.PHONY: help

# Colors for output
RED := \033[0;31m
GREEN := \033[0;32m
YELLOW := \033[0;33m
BLUE := \033[0;34m
NC := \033[0m # No Color

# ============================================
# Help
# ============================================

help: ## Show this help message
	@echo '$(BLUE)════════════════════════════════════════════════$(NC)'
	@echo '$(BLUE)  DevMonitor - Docker Development Commands$(NC)'
	@echo '$(BLUE)════════════════════════════════════════════════$(NC)'
	@echo ''
	@echo 'Usage: make [target]'
	@echo ''
	@echo '$(GREEN)Available targets:$(NC)'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  $(YELLOW)%-20s$(NC) %s\n", $$1, $$2}' $(MAKEFILE_LIST)
	@echo ''

# ============================================
# Docker Management
# ============================================

build: ## Build all Docker containers
	@echo "$(GREEN)Building Docker containers...$(NC)"
	docker-compose build --no-cache

up: ## Start all containers in background
	@echo "$(GREEN)Starting containers...$(NC)"
	docker-compose up -d

down: ## Stop and remove all containers
	@echo "$(RED)Stopping containers...$(NC)"
	docker-compose down

restart: ## Restart all containers
	@echo "$(YELLOW)Restarting containers...$(NC)"
	docker-compose restart

stop: ## Stop all containers (without removing)
	@echo "$(YELLOW)Stopping containers...$(NC)"
	docker-compose stop

start: ## Start existing containers
	@echo "$(GREEN)Starting existing containers...$(NC)"
	docker-compose start

ps: ## Show running containers
	@docker-compose ps

stats: ## Show container resource usage
	@docker stats --format "table {{.Container}}\t{{.CPUPerc}}\t{{.MemUsage}}\t{{.NetIO}}\t{{.BlockIO}}"

clean: ## Remove all containers, volumes and images
	@echo "$(RED)Cleaning up Docker resources...$(NC)"
	@read -p "Are you sure? This will remove ALL data! (y/N): " confirm && \
	if [ "$$confirm" = "y" ] || [ "$$confirm" = "Y" ]; then \
		docker-compose down -v --rmi all --remove-orphans; \
		echo "$(GREEN)Cleanup complete!$(NC)"; \
	else \
		echo "$(YELLOW)Cleanup cancelled.$(NC)"; \
	fi

rebuild: ## Rebuild and restart all containers
	@echo "$(YELLOW)Rebuilding containers...$(NC)"
	docker-compose down
	docker-compose build --no-cache
	docker-compose up -d
	@echo "$(GREEN)Rebuild complete!$(NC)"

# ============================================
# Initial Setup
# ============================================

install: ## Complete first-time installation
	@echo "$(GREEN)════════════════════════════════════════$(NC)"
	@echo "$(GREEN)  DevMonitor - Initial Setup$(NC)"
	@echo "$(GREEN)════════════════════════════════════════$(NC)"
	@echo ""
	@echo "$(BLUE)Step 1/8: Creating backend .env file...$(NC)"
	@if [ ! -f backend/.env ]; then cp backend/.env.example backend/.env; fi
	@echo "$(BLUE)Step 2/8: Creating frontend .env file...$(NC)"
	@if [ ! -f frontend/.env ]; then \
		echo "REACT_APP_API_URL=http://localhost/api" > frontend/.env; \
		echo "REACT_APP_WS_URL=ws://localhost:8080" >> frontend/.env; \
	fi
	@echo "$(BLUE)Step 3/8: Building Docker containers...$(NC)"
	@docker-compose build
	@echo "$(BLUE)Step 4/8: Starting containers...$(NC)"
	@docker-compose up -d
	@sleep 5
	@echo "$(BLUE)Step 5/8: Installing backend dependencies...$(NC)"
	@docker-compose exec backend composer install --no-interaction
	@echo "$(BLUE)Step 6/8: Generating application key...$(NC)"
	@docker-compose exec backend php artisan key:generate
	@echo "$(BLUE)Step 7/8: Running database migrations...$(NC)"
	@docker-compose exec backend php artisan migrate --force
	@echo "$(BLUE)Step 8/8: Seeding database...$(NC)"
	@docker-compose exec backend php artisan db:seed
	@echo ""
	@echo "$(GREEN)════════════════════════════════════════$(NC)"
	@echo "$(GREEN)  Installation Complete! 🎉$(NC)"
	@echo "$(GREEN)════════════════════════════════════════$(NC)"
	@echo ""
	@echo "$(YELLOW)Access your application:$(NC)"
	@echo "  Frontend: http://localhost:3000"
	@echo "  Backend API: http://localhost/api"
	@echo "  WebSocket: ws://localhost:8080"
	@echo ""
	@echo "$(YELLOW)Default credentials:$(NC)"
	@echo "  Email: admin@devmonitor.com"
	@echo "  Password: password"
	@echo ""

setup: install ## Alias for install

# ============================================
# Backend (Laravel) Commands
# ============================================

composer-install: ## Install Composer dependencies
	@echo "$(GREEN)Installing Composer dependencies...$(NC)"
	docker-compose exec backend composer install --no-interaction

composer-update: ## Update Composer dependencies
	@echo "$(YELLOW)Updating Composer dependencies...$(NC)"
	docker-compose exec backend composer update --no-interaction

composer-dump: ## Dump Composer autoload
	docker-compose exec backend composer dump-autoload

artisan: ## Run artisan command (usage: make artisan CMD="migrate")
	docker-compose exec backend php artisan $(CMD)

key-generate: ## Generate application key
	docker-compose exec backend php artisan key:generate

jwt-secret: ## Generate JWT secret key
	docker-compose exec backend php artisan jwt:secret

# ============================================
# Database Commands
# ============================================

migrate: ## Run database migrations
	@echo "$(GREEN)Running migrations...$(NC)"
	docker-compose exec backend php artisan migrate

migrate-fresh: ## Drop all tables and re-run migrations
	@echo "$(RED)Dropping all tables and running fresh migrations...$(NC)"
	docker-compose exec backend php artisan migrate:fresh

migrate-refresh: ## Rollback and re-run migrations
	@echo "$(YELLOW)Rolling back and re-running migrations...$(NC)"
	docker-compose exec backend php artisan migrate:refresh

migrate-rollback: ## Rollback last migration
	docker-compose exec backend php artisan migrate:rollback

migrate-status: ## Show migration status
	docker-compose exec backend php artisan migrate:status

seed: ## Seed the database
	@echo "$(GREEN)Seeding database...$(NC)"
	docker-compose exec backend php artisan db:seed

migrate-seed: ## Run migrations and seed database
	@echo "$(GREEN)Running migrations and seeding...$(NC)"
	docker-compose exec backend php artisan migrate:fresh --seed

db-reset: migrate-fresh seed ## Reset database (fresh migration + seed)

# ============================================
# Testing Commands
# ============================================

test: ## Run all tests
	@echo "$(GREEN)Running tests...$(NC)"
	docker-compose exec backend php artisan test

test-feature: ## Run feature tests only
	docker-compose exec backend php artisan test --testsuite=Feature

test-unit: ## Run unit tests only
	docker-compose exec backend php artisan test --testsuite=Unit

test-coverage: ## Run tests with coverage report
	@echo "$(GREEN)Running tests with coverage...$(NC)"
	docker-compose exec backend php artisan test --coverage --min=70

test-parallel: ## Run tests in parallel
	docker-compose exec backend php artisan test --parallel

pest: ## Run Pest tests
	docker-compose exec backend ./vendor/bin/pest

pest-coverage: ## Run Pest with coverage
	docker-compose exec backend ./vendor/bin/pest --coverage

# ============================================
# Cache Management
# ============================================

cache-clear: ## Clear all caches
	@echo "$(YELLOW)Clearing all caches...$(NC)"
	docker-compose exec backend php artisan cache:clear
	docker-compose exec backend php artisan config:clear
	docker-compose exec backend php artisan route:clear
	docker-compose exec backend php artisan view:clear
	docker-compose exec backend php artisan event:clear
	@echo "$(GREEN)Cache cleared!$(NC)"

cache-config: ## Cache configuration
	docker-compose exec backend php artisan config:cache

cache-routes: ## Cache routes
	docker-compose exec backend php artisan route:cache

cache-views: ## Cache views
	docker-compose exec backend php artisan view:cache

cache-events: ## Cache events
	docker-compose exec backend php artisan event:cache

optimize: ## Optimize application (cache all)
	@echo "$(GREEN)Optimizing application...$(NC)"
	docker-compose exec backend php artisan optimize
	docker-compose exec backend php artisan config:cache
	docker-compose exec backend php artisan route:cache
	docker-compose exec backend php artisan view:cache
	@echo "$(GREEN)Optimization complete!$(NC)"

optimize-clear: ## Clear all optimizations
	docker-compose exec backend php artisan optimize:clear

# ============================================
# Queue & Scheduler Commands
# ============================================

queue-work: ## Start queue worker
	docker-compose exec backend php artisan queue:work

queue-listen: ## Listen to queue
	docker-compose exec backend php artisan queue:listen

queue-restart: ## Restart queue workers
	docker-compose exec backend php artisan queue:restart

queue-failed: ## Show failed jobs
	docker-compose exec backend php artisan queue:failed

queue-retry: ## Retry failed job (usage: make queue-retry ID=1)
	docker-compose exec backend php artisan queue:retry $(ID)

queue-retry-all: ## Retry all failed jobs
	docker-compose exec backend php artisan queue:retry all

queue-flush: ## Flush all failed jobs
	docker-compose exec backend php artisan queue:flush

schedule-run: ## Run scheduled commands
	docker-compose exec backend php artisan schedule:run

schedule-work: ## Run scheduler in foreground
	docker-compose exec backend php artisan schedule:work

# ============================================
# Frontend Commands
# ============================================

npm-install: ## Install npm dependencies
	@echo "$(GREEN)Installing npm dependencies...$(NC)"
	docker-compose exec frontend npm install

npm-update: ## Update npm dependencies
	docker-compose exec frontend npm update

npm-build: ## Build frontend for production
	@echo "$(GREEN)Building frontend...$(NC)"
	docker-compose exec frontend npm run build

npm-lint: ## Run ESLint
	docker-compose exec frontend npm run lint

npm-test: ## Run frontend tests
	docker-compose exec frontend npm test

npm-clean: ## Clean node_modules and reinstall
	@echo "$(YELLOW)Cleaning and reinstalling npm dependencies...$(NC)"
	docker-compose exec frontend rm -rf node_modules package-lock.json
	docker-compose exec frontend npm install

# ============================================
# Shell Access
# ============================================

shell-backend: ## Access backend container shell
	@echo "$(BLUE)Entering backend container...$(NC)"
	docker-compose exec backend sh

shell-frontend: ## Access frontend container shell
	@echo "$(BLUE)Entering frontend container...$(NC)"
	docker-compose exec frontend sh

shell-postgres: ## Access PostgreSQL shell
	@echo "$(BLUE)Entering PostgreSQL...$(NC)"
	docker-compose exec postgres psql -U devmonitor_user -d devmonitor

shell-redis: ## Access Redis CLI
	@echo "$(BLUE)Entering Redis CLI...$(NC)"
	docker-compose exec redis redis-cli

bash-backend: ## Access backend bash shell
	docker-compose exec backend bash

# ============================================
# Logs
# ============================================

logs: ## Show logs from all containers
	docker-compose logs -f

logs-backend: ## Show backend logs
	docker-compose logs -f backend

logs-frontend: ## Show frontend logs
	docker-compose logs -f frontend

logs-nginx: ## Show nginx logs
	docker-compose logs -f nginx

logs-postgres: ## Show PostgreSQL logs
	docker-compose logs -f postgres

logs-redis: ## Show Redis logs
	docker-compose logs -f redis

logs-reverb: ## Show Reverb WebSocket logs
	docker-compose logs -f reverb

logs-queue: ## Show queue worker logs
	docker-compose logs -f queue

laravel-logs: ## Show Laravel application logs
	docker-compose exec backend tail -f storage/logs/laravel.log

# ============================================
# Database Backup & Restore
# ============================================

db-backup: ## Backup database
	@echo "$(GREEN)Creating database backup...$(NC)"
	@mkdir -p backups
	@docker-compose exec -T postgres pg_dump -U devmonitor_user devmonitor > backups/backup_$$(date +%Y%m%d_%H%M%S).sql
	@echo "$(GREEN)Backup created in backups/ directory$(NC)"

db-restore: ## Restore database from backup (usage: make db-restore FILE=backup.sql)
	@echo "$(YELLOW)Restoring database from $(FILE)...$(NC)"
	@docker-compose exec -T postgres psql -U devmonitor_user devmonitor < backups/$(FILE)
	@echo "$(GREEN)Database restored!$(NC)"

# ============================================
# Code Quality & Analysis
# ============================================

phpstan: ## Run PHPStan static analysis
	docker-compose exec backend ./vendor/bin/phpstan analyse

php-cs-fixer: ## Run PHP CS Fixer
	docker-compose exec backend ./vendor/bin/php-cs-fixer fix

php-cs-fixer-dry: ## Run PHP CS Fixer (dry run)
	docker-compose exec backend ./vendor/bin/php-cs-fixer fix --dry-run --diff

lint-backend: phpstan php-cs-fixer-dry ## Run all backend linters

lint-frontend: npm-lint ## Run frontend linters

lint: lint-backend lint-frontend ## Run all linters

# ============================================
# Health & Monitoring
# ============================================

health: ## Check application health
	@echo "$(BLUE)Checking application health...$(NC)"
	@curl -s http://localhost/api/health | jq '.' || echo "Health check failed"

ping-backend: ## Ping backend API
	@curl -s http://localhost/api/health

ping-frontend: ## Ping frontend
	@curl -s http://localhost:3000

status: ## Show complete system status
	@echo "$(BLUE)════════════════════════════════════════$(NC)"
	@echo "$(BLUE)  DevMonitor System Status$(NC)"
	@echo "$(BLUE)════════════════════════════════════════$(NC)"
	@echo ""
	@echo "$(YELLOW)Docker Containers:$(NC)"
	@docker-compose ps
	@echo ""
	@echo "$(YELLOW)Application Health:$(NC)"
	@curl -s http://localhost/api/health | jq '.' 2>/dev/null || echo "  Backend: $(RED)Down$(NC)"
	@curl -s http://localhost:3000 >/dev/null 2>&1 && echo "  Frontend: $(GREEN)Up$(NC)" || echo "  Frontend: $(RED)Down$(NC)"
	@echo ""

# ============================================
# Utility Commands
# ============================================

fresh: ## Fresh install (clean + install)
	@make clean
	@make install

update: ## Update dependencies
	@make composer-update
	@make npm-update

permissions: ## Fix file permissions
	@echo "$(YELLOW)Fixing file permissions...$(NC)"
	docker-compose exec backend chmod -R 775 storage bootstrap/cache
	docker-compose exec backend chown -R www-data:www-data storage bootstrap/cache
	@echo "$(GREEN)Permissions fixed!$(NC)"

tinker: ## Open Laravel Tinker
	docker-compose exec backend php artisan tinker

routes: ## List all routes
	docker-compose exec backend php artisan route:list

models: ## List all models
	docker-compose exec backend php artisan model:show

info: ## Show application information
	@docker-compose exec backend php artisan about

env: ## Show environment variables
	@docker-compose exec backend php artisan env

version: ## Show versions of all components
	@echo "$(BLUE)Component Versions:$(NC)"
	@echo "PHP: $$(docker-compose exec backend php -v | head -n 1)"
	@echo "Composer: $$(docker-compose exec backend composer -V)"
	@echo "Node: $$(docker-compose exec frontend node -v)"
	@echo "npm: $$(docker-compose exec frontend npm -v)"
	@echo "PostgreSQL: $$(docker-compose exec postgres psql --version)"
	@echo "Redis: $$(docker-compose exec redis redis-cli --version)"

# ============================================
# Deployment Simulation
# ============================================

deploy-check: ## Run pre-deployment checks
	@echo "$(BLUE)Running pre-deployment checks...$(NC)"
	@make test
	@make lint
	@echo "$(GREEN)Pre-deployment checks passed!$(NC)"

production-build: ## Build for production
	@echo "$(GREEN)Building for production...$(NC)"
	docker-compose exec backend composer install --no-dev --optimize-autoloader
	docker-compose exec backend php artisan config:cache
	docker-compose exec backend php artisan route:cache
	docker-compose exec backend php artisan view:cache
	docker-compose exec frontend npm run build
	@echo "$(GREEN)Production build complete!$(NC)"