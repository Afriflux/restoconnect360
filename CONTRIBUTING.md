# 🤝 Contributing to RestoConnect360

First off, thank you for considering contributing to RestoConnect360! It's people like you that make RestoConnect360 such a great tool for restaurants across Africa.

## 📋 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [How Can I Contribute?](#how-can-i-contribute)
- [Style Guidelines](#style-guidelines)
- [Commit Guidelines](#commit-guidelines)
- [Pull Request Process](#pull-request-process)

## 📜 Code of Conduct

This project and everyone participating in it is governed by our Code of Conduct. By participating, you are expected to uphold this code.

## 🚀 Getting Started

1. **Fork the repository** on GitHub
2. **Clone your fork** locally
   ```bash
   git clone https://github.com/YOUR_USERNAME/restoconnect360.git
   cd restoconnect360
   ```
3. **Create a branch** for your changes
   ```bash
   git checkout -b feature/your-feature-name
   ```
4. **Set up the development environment**
   ```bash
   ./start-restoconnect360.sh
   ```

## 💡 How Can I Contribute?

### 🐛 Reporting Bugs

Before creating bug reports, please check existing issues to avoid duplicates. When creating a bug report, include:

- **Clear title and description**
- **Steps to reproduce** the problem
- **Expected vs actual behavior**
- **Screenshots** if applicable
- **Environment details** (OS, Node version, etc.)

### ✨ Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, include:

- **Clear title and description**
- **Use case** - why is this enhancement needed?
- **Proposed solution** - how should it work?
- **Alternatives considered**

### 🔧 Code Contributions

1. **Check existing issues** or create a new one
2. **Comment on the issue** to let others know you're working on it
3. **Follow the style guidelines** below
4. **Write tests** for your changes
5. **Update documentation** as needed
6. **Submit a pull request**

## 🎨 Style Guidelines

### PHP (Laravel)

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard
- Use **PHPDoc** blocks for all methods
- Run `composer run lint` before committing

```php
/**
 * Process payment using delegation service
 *
 * @param array $paymentData
 * @return PaymentResult
 */
public function processPayment(array $paymentData): PaymentResult
{
    // Implementation
}
```

### TypeScript (NestJS/Next.js)

- Follow [Airbnb JavaScript Style Guide](https://github.com/airbnb/javascript)
- Use **TypeScript** strictly, no `any` types
- Run `npm run lint` before committing

```typescript
/**
 * Generate QR code for a specific type
 * @param type - The QR code type
 * @param data - Associated data
 * @returns Generated QR code URL
 */
async generateQRCode(type: QRCodeType, data: QRData): Promise<string> {
  // Implementation
}
```

### CSS/Tailwind

- Use **Tailwind CSS** utility classes
- Create custom components in `globals.css` only when necessary
- Follow **mobile-first** approach

## 📝 Commit Guidelines

We follow [Conventional Commits](https://www.conventionalcommits.org/) specification:

### Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- `feat:` New feature
- `fix:` Bug fix
- `docs:` Documentation changes
- `style:` Code style changes (formatting, etc.)
- `refactor:` Code refactoring
- `perf:` Performance improvements
- `test:` Adding or updating tests
- `chore:` Maintenance tasks
- `ci:` CI/CD changes
- `build:` Build system changes

### Examples

```bash
feat(payments): add Wave payment provider integration

Implements Wave payment provider with automatic commission calculation
and webhook handling for payment confirmations.

Closes #123
```

```bash
fix(qr): resolve QR code generation error for table type

Fixed issue where table QR codes were not generating properly
due to missing restaurant_id validation.

Fixes #456
```

## 🔄 Pull Request Process

1. **Update documentation** for any changed functionality
2. **Add tests** that cover your changes
3. **Ensure all tests pass**
   ```bash
   npm run test
   php artisan test
   ```
4. **Update the CHANGELOG.md** with your changes
5. **Request review** from maintainers
6. **Address review comments** promptly
7. **Squash commits** if requested

### PR Title Format

Use the same format as commit messages:

```
feat(scope): description of changes
```

### PR Description Template

```markdown
## Description
Brief description of what this PR does

## Type of Change
- [ ] Bug fix (non-breaking change which fixes an issue)
- [ ] New feature (non-breaking change which adds functionality)
- [ ] Breaking change (fix or feature that would cause existing functionality to not work as expected)
- [ ] Documentation update

## Testing
How has this been tested?

## Checklist
- [ ] My code follows the style guidelines
- [ ] I have performed a self-review
- [ ] I have commented my code where necessary
- [ ] I have updated the documentation
- [ ] My changes generate no new warnings
- [ ] I have added tests that prove my fix/feature works
- [ ] New and existing tests pass locally
```

## 🧪 Testing

### Backend Tests

```bash
# NestJS
cd restoconnect-backend
npm run test
npm run test:e2e
npm run test:cov

# Laravel
cd afriflux-restoconnect360
php artisan test
php artisan test --coverage
```

### Frontend Tests

```bash
cd restoconnect-frontend
npm run test
npm run test:e2e
```

## 📚 Additional Resources

- [Project Documentation](docs/)
- [API Reference](docs/api.md)
- [Architecture Guide](docs/architecture.md)
- [Deployment Guide](docs/deployment.md)

## ❓ Questions?

Feel free to:
- Open a [GitHub Discussion](https://github.com/Afriflux/restoconnect360/discussions)
- Join our [Discord community](https://discord.gg/restoconnect360)
- Email us at dev@afriflux.com

## 🙏 Thank You!

Your contributions help make RestoConnect360 better for restaurants across Africa. We appreciate your time and effort! 🌍❤️

---

**Happy Contributing!** 🚀
