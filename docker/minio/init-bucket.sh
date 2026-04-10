#!/bin/bash
# MinIO Bucket Initialization Script
# Usage: ./docker/minio/init-bucket.sh
# Run this AFTER docker-compose up -d

set -e

MINIO_ALIAS="local"
MINIO_ENDPOINT="http://localhost:9000"
MINIO_USER="${AWS_ACCESS_KEY_ID:-minioadmin}"
MINIO_PASS="${AWS_SECRET_ACCESS_KEY:-minioadmin}"
BUCKET="${AWS_BUCKET:-portfolio}"

echo "🪣  Initializing MinIO bucket..."

# Wait for MinIO to be ready
echo "⏳  Waiting for MinIO to start..."
until curl -s "${MINIO_ENDPOINT}/minio/health/live" > /dev/null 2>&1; do
    sleep 2
    echo "   Still waiting..."
done

echo "✅  MinIO is up!"

# Check if mc (MinIO Client) is installed
if ! command -v mc &> /dev/null; then
    echo "📦  Installing MinIO Client (mc)..."
    curl -sSL https://dl.min.io/client/mc/release/darwin-amd64/mc -o /usr/local/bin/mc 2>/dev/null \
        || curl -sSL https://dl.min.io/client/mc/release/linux-amd64/mc -o /usr/local/bin/mc
    chmod +x /usr/local/bin/mc
fi

# Configure alias
mc alias set ${MINIO_ALIAS} ${MINIO_ENDPOINT} ${MINIO_USER} ${MINIO_PASS} --api S3v4 > /dev/null

# Create bucket if it doesn't exist
if mc ls ${MINIO_ALIAS}/${BUCKET} > /dev/null 2>&1; then
    echo "ℹ️   Bucket '${BUCKET}' already exists."
else
    echo "📁  Creating bucket '${BUCKET}'..."
    mc mb ${MINIO_ALIAS}/${BUCKET}
fi

# Set bucket policy to public (so uploaded images are accessible)
echo "🔓  Setting public read policy..."
mc anonymous set download ${MINIO_ALIAS}/${BUCKET}

echo ""
echo "✅  MinIO setup complete!"
echo "   Bucket: ${BUCKET}"
echo "   Console: http://localhost:9001 (${MINIO_USER}/${MINIO_PASS})"
echo "   API:     ${MINIO_ENDPOINT}"
